<?php
class MailMessage extends YiiMailMessage
{
    const TEMPLATES_DIR = 'mail';

    public function setBody($body = '', $contentType = null, $charset = null) {
        if ($this->view !== null) {

            if (!is_array($body)) $body = array('body'=>$body);

            $template = Yii::app()->getBasePath().DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR
                .self::TEMPLATES_DIR.DIRECTORY_SEPARATOR.$this->view.Yii::app()->viewRenderer->fileExtension;
            $body = Yii::app()->viewRenderer->renderFile(null, $template, $body, true);
        }

        return $this->message->setBody($body, $contentType, $charset);
    }
}
