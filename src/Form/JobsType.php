<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Jobs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints as Assert;
class JobsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('job_title', TextType::class, [
                'constraints' =>[
                    new NotBlank([
                        'message'=>'Please enter job title'
                    ]),
                    new Regex([
                        'pattern' => '/\d/',
                        'match' => false,
                        'message' => 'Your title is not valid',
                    ]),
                ],
                'label' => 'Job Title',
                'row_attr' => [
                    'class' => 'input-group',
                ],
            ])
            ->add('job_description',TextType::class,[
                'required'=>true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter job description'
                    ])
                ],
                'label' => 'Job Description',
                'row_attr' => [
                'class' => 'input-group',
                ],
            ])
            ->add('skills',TextType::class,[
                'required'=>true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter job skills'
                    ])
                ],
                'label' => 'Job skills',
                'row_attr' => [
                    'class' => 'input-group',
                ],
            ]) 
            ->add('job_location',TextType::class,[
                'required'=>true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter job location'
                    ]),
                    new Regex([
                        'pattern' =>'/\d/',
                        'match' => false,
                        'message' => 'your location is not valid',
                    ]),
                ],
                'label' => 'Job Location',
                'row_attr' => [
                    'class' => 'input-group',
                ],
            ])
            ->add('experience',NumberType::class,[
                'required' => true,
                'constraints' =>[
                    new NotBlank([
                        'message' => 'Please enter valid experience'
                    ]),
                    new Assert\Regex([
                        'pattern' => '/\D/',
                        'match' => false,
                        'message' => 'Your phone number contain an alphabet',
                    ]),
                ],
                'label' => 'Experience',
                'row_attr' => [
                    'class' => 'input-group',
                ],

            ])
            ->add('expiry')
            ->getForm();
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Jobs::class,
        ]);
    }
}
