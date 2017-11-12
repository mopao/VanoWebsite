<?php

namespace VanoFashion\EShoppingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ItemStockType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('itemSize', NumberType::class , array('label'=> 'Size:',
            'label_attr' => array('class' => ' control-label')))
                ->add('typeSize', ChoiceType::class, array(
                    'choices'  => array(
                    'US' => 'us',
                    'EU' => 'eu',
                    
             ), 'label'=> 'Size type:'))
                ->add('price', NumberType::class)                
                ->add('quantity', integerType::class ,  array('label'=> 'Quantity:'));
                //->add('addingDate', DateTimeType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VanoFashion\EShoppingBundle\Entity\ItemStock'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'vanofashion_eshoppingbundle_itemstock';
    }


}
