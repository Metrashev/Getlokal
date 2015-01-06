<?php

class backendStaticPageForm extends BaseStaticPageForm
{
    public function configure()
    {
        unset(
            $this['country_id'],
            $this['root_id'],
            $this['lft'],
            $this['rgt'],
            $this['level']
        );

        $this->setWidget('parent', new sfWidgetFormDoctrineChoiceNestedSet(array(
            'model' => 'StaticPage',
            'add_empty' => 'Select parent page'
        )));

        if ($this->getObject()->getNode()->hasParent()) {
            $parent = $this->getObject()->getNode()->getParent();
            if ($parent) {
                $this->setDefault('parent', $this->getObject()->getNode()->getParent()->getId());
            }
        }

        $this->setValidator('parent', new sfValidatorDoctrineChoiceNestedSet(array(
            'model' => 'StaticPage',
            'required' => false,
            'node' => $this->getObject()
        )));

        if(sfContext::getInstance()->getUser()->getCountry()->getSlug() == 'fi'){
            $this->embedI18n(array(sfContext::getInstance()->getUser()->getCountry()->getSlug(), 'ru', 'en'));
        }
        else{
            $this->embedI18n(array(sfContext::getInstance()->getUser()->getCountry()->getSlug(), 'en'));
        }

    }

    public function doSave($con = null)
    {
        // set country based on domain automatically
        $this->getObject()->setCountryId(sfContext::getInstance()->getUser()->getCountry()->getId());
        $prevParent = $this->getObject()->getNode()->getParent();

        parent::doSave($con);

        if ($this->getValue('parent')) {
            $parent = Doctrine_Core::getTable('StaticPage')->findOneById($this->getValue('parent'));
            $newParent = (!$prevParent && $parent) || ($prevParent && $parent && $prevParent->getId() != $parent->getId());
            if ($this->isNew()) {
                $this->getObject()->getNode()->insertAsLastChildOf($parent);
            } elseif ($newParent) {
                $this->getObject()->getNode()->moveAsLastChildOf($parent);
            }
        } else {
            $tree = Doctrine_Core::getTable('StaticPage')->getTree();
            if ($this->isNew()) {
                $tree->createRoot($this->getObject());
            } else {
                $this->getObject()->getNode()->makeRoot($this->getObject()->getId());
            }
        }
    }

}
