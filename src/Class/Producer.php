<?php

namespace App\Class;



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
}