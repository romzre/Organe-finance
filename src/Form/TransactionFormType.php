<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\User;
use App\Entity\Transaction;
use App\Entity\WayTransaction;
use App\Entity\TypeTransaction;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class TransactionFormType extends AbstractType
{

    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

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
            ->add('Category', EntityType::class, [
                'class' => Category::class,
                'query_builder' => function (CategoryRepository $categoryRepository) {
                   return  $categoryRepository->getCategoriesByUser($this->security->getUser());
                },
                'choice_label' => function ($category) {
                    return $category->getLabel();
                },
                'choice_attr' => function(Category $category, $key, $value) {
                    return ['style' => 'background:'.$category->getColor().';'];
                },
            ])
            ->add('libelle')
            ->add('sum')
            ->add('dateTransaction',  DateType::class, ['widget' => 'single_text'])
            // ->add('Periodicity')


            // ->add('Periodicity')
            // ->add('createdAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
