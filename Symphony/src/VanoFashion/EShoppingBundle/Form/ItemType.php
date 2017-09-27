<?php

namespace VanoFashion\EShoppingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;



class ItemType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('codeItem',  TextType::class)
                ->add('title', TextType::class)
                ->add('color', TextType::class)
                ->add('descrip', TextareaType::class)
                ->add('price', TextType::class)
                ->add('brand', TextType::class)
                ->add('available' , CheckboxType::class, array('required' => false))
                ->add('itemLabel', TextType::class)
                ->add('files',  FileType::class,  array('multiple' =>true , 'label'=>'Images' )                   )
                ->add('gender', EntityType::class, array(
                        'class'        => 'VanoFashionEShoppingBundle:ItemGender',
                        'choice_label' => 'gender',
                        'expanded'     => true
                      ))
                ->add('product', EntityType::class, array(
                        'class'        => 'VanoFashionEShoppingBundle:ItemProduct',
                        'choice_label' => 'name',
                        'expanded'     => true
                      ))
                ->add('stock', ItemStockType::class)
                ->add('save',      SubmitType::class)
                ->add('reset',       ResetType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VanoFashion\EShoppingBundle\Entity\Item'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'vanofashion_eshoppingbundle_item';
    }


}
