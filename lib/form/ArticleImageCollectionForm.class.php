<?php
class ArticleImageCollectionForm extends sfForm {
        
    public function configure() {
        parent::configure();

        if (!($object = $this->getOption('object')) || !($object instanceof Article))
        {
                throw new InvalidArgumentException('Article image object doesn`t exist');
        }

        for ($i = 0; $i < $this->getOption('size', 6); $i++)
        {
            $image = new ArticleImage();
            $image->setArticle($object);

            $form = new ArtImageForm($image);
            //$form->setValidator('descrption', new sfValidatorString(array('max_length' => 255, 'required' => true) ) );
            $this->embedForm($i, $form);
        }
        
        $this->mergePostValidator(new ArticlePhotoValidatorSchema());
    }
}