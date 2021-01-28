<?php

namespace App\Form;

use App\Entity\MrBook;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MrBookType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('name')
      ->add('page_cnt')
      ->add('price')
      ->add('existence')
      ->add('year')
      ->add('isbn')
      ->add('url')
      ->add('description')// ->add('author')
    ;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => MrBook::class,
    ]);
  }
}
