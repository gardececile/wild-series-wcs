<?php


namespace App\Form;



use Symfony\Component\Form\FormBuilderInterface;

class ProgramSearchType extends \Symfony\Component\Form\AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('searchField');
    }
}