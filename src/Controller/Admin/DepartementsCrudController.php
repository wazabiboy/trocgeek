<?php

namespace App\Controller\Admin;

use App\Entity\Departements;
use phpDocumentor\Reflection\Types\Integer;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

class DepartementsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Departements::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
        
            TextField::new('name'),
            IntegerField::new('number'),
            AssociationField::new('regions')
        ];
    }
    
}
