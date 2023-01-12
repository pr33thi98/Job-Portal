<?php

namespace App\Class;

use App\Entity\Log;
use Doctrine\ORM\EntityManagerInterface;

class Producer
{
    public function producerConfig($userId, $logTime, $jobId, $type, $description)
    {
        $producer = new \RdKafka\Producer();

        $producer->setLogLevel(LOG_DEBUG);

        $producer->addBrokers("127.0.0.1");

        $topic = $producer->newTopic("Job-Log");

        $decoded_array['userid'] = $userId;

        $decoded_array['logtime'] = $logTime;

        $decoded_array['jobid'] = $jobId;

        $decoded_array['description'] = $description;

        $decoded_array['type'] = $type;

        $value = json_encode($decoded_array);

        $topic->produce(RD_KAFKA_PARTITION_UA, 0, $value);

        for ($flushRetries = 0; $flushRetries < 10; $flushRetries++) 
        {
            $result = $producer->flush(10000);
            
            if (RD_KAFKA_RESP_ERR_NO_ERROR == $result) 
            {
                break;
            }
        }
        if (RD_KAFKA_RESP_ERR_NO_ERROR !== $result) 
        {
            throw new \RuntimeException('Was unable to flush, messages might be lost!');
        }     
    }

    public function consumerConfig($entityManager): void
    {

        $conf = new \RdKafka\Conf();

        $conf->set('metadata.broker.list', '127.0.0.1');

        $conf->set('group.id', 'group1');

        $conf->set('auto.offset.reset', 'earliest');

        $consumer = new \RdKafka\KafkaConsumer($conf);

        $consumer->subscribe(['Job-Log']);

        while (true) 
        {
            $message = $consumer->consume(5*1000);
            
            $batch = 0;

            switch ($message->err) 
            {
                case RD_KAFKA_RESP_ERR_NO_ERROR:

                    $this->logInsertion($batch, $message->payload, $entityManager);

                case RD_KAFKA_RESP_ERR__PARTITION_EOF:

                    $entityManager->flush();   
            }
        }
    }

    public function logInsertion($batch, $message, EntityManagerInterface $entityManager)
    {
        $log = new Log();

        $obj = json_decode($message);

        $userId = $obj->userid;

        $logTime = $obj->logtime;

        $jobId = $obj->jobid;

        $description = $obj->description;

        $type = $obj->type;

        $log->setUserId($userId);

        $log->setLogTime($logTime);

        $log->setJobId($jobId);

        $log->setDescription($description);

        $log->setType($type);

        $entityManager->persist($log);

        $batch++;

        while ($batch == 50)
        {
            $entityManager->flush();
        }
    }
}