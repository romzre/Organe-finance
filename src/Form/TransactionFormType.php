<?php

namespace App\Form;

use App\Entity\Transaction;
use App\Entity\WayTransaction;
use App\Entity\TypeTransaction;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class TransactionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('TypeTransaction', EntityType::class, [
                'class' => TypeTransaction::class,
                'choice_label' => function ($typetransaction) {
                    return $typetransaction->getLabel();
                }
            ])
            ->add('WayTransaction', EntityType::class, [
                'class' => WayTransaction::class,
                'choice_label' => function ($waytransaction) {
                    return $waytransaction->getLabel();
                }
            ])
            ->add('libelle')
            ->add('sum')
            ->add('dateTransaction',  DateType::class, ['widget' => 'single_text'])
            


            // ->add('Periodicity')
            // ->add('createdAt')
            // ->add('Cycle')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
