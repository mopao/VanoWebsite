<?php

namespace VanoFashion\EShoppingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\*;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class itemType extends AbstractType
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
                ->add('available' , CheckboxType::class, , array('required' => false))
                ->add('itemLabel', TextType::class)
                ->add('categories', CollectionType::class, array(
                        'entry_type'   => ImageType::class,
                        'allow_add'    => true,
                        'allow_delete' => true
                      ))
                ->add('type')
                ->add('product')
                ->add('stock');
                ->add('save',      SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VanoFashion\EShoppingBundle\Entity\item'
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
