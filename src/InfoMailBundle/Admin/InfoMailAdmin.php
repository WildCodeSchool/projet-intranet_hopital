<?php
namespace InfoMailBundle\Admin;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Sonata\AdminBundle\Validator\ErrorElement;

class InfoMailAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('type', 'choice', array(
                'label'    => 'Type d\'email',
                'required' => true,
                'choices' => array(
                    'mail de bienvenue' => 'mail de bienvenue',
                    'mail d\'information' => 'mail d\'information'
                )
            ))
            ->add('subject', null, array('label' => 'Sujet'))
            ->add('body', CKEditorType::class, array(
                'label' => 'Corps du message',
                'config_name' => 'my_config'))
            ->add('uploadedFiles', FileType::class, array(
                    'label' => 'pièces jointes',
                    'required' => false,
                    'multiple' => true,
                    'data_class' => null,)
            )
        ;
    }
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('type')
            ->add('subject', null, array('label' => 'Sujet'))
        ;
    }
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('subject', null, array('label' => 'Sujet'))
            ->add('type')
            ->add('files', null, array('label' => 'Pièces jointes'))
            ->add('date_last_send', 'datetime', array('label'=>'Date de dernier envoi','format' => 'd/m/Y H:i'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                    'show' => array(),
                    'delete' => array(),
                    'send' => array(
                        'template' => 'InfoMailBundle:InfoMail:list__action_send.html.twig'
                    )
                )
            ))
        ;
    }
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('type')
            ->add('date_last_send', null, array('label' => 'Date de dernier envoi'))
            ->add('subject', null, array('label' => 'Sujet'))
            ->add('body', null, array('label' => 'Message'))
            ->add('files', null, array('label' => 'Pièces jointes'))
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('send', $this->getRouterIdParameter().'/send');
    }
}