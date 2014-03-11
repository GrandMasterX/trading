<?php
class Controller extends CController
{
    public $layout = '//layouts/clear';

    public $body_class = '';
    public $menu = array();

    public $sMenu = array();
    public $breadcrumbs = array();
    public $sub_menu = array();
    public $model;
    public $route;

    public $domain;
    public $siteName;
    public $isGuest;
    public $basePath;
    public $pageDescription;
    public $userId;

    const DATE_FORMAT = 'Y-m-d';

    const NOT_AJAX_REDIRECT = '/';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('deny'),
        );
    }

    public function init()
    {
        parent::init();

        $this->domain = Yii::app()->params['domain'];
        $this->basePath = 'http://'.Yii::app()->params['domain'];
        $this->siteName = Yii::app()->name;
        $this->isGuest = Yii::app()->user->isGuest;
        $this->userId = !Yii::app()->user->isGuest ? Yii::app()->user->getId() : 0;
    }

    public function beforeRender($view)
    {
        $this->sMenu = $this->getPreparedMenu($this->menu);

        return $view;
    }

    protected function getPreparedMenu($menus) {

        foreach ($menus as &$menu) {

            $menu['label'] = Yii::t('app', $menu['label']);
            if (is_array($menu['url'])) {
                $menu['route'] = trim((!empty($menu['url'][0]) ? $menu['url'][0] : $menu['url']['route']),'/');
                unset($menu['url'][0]);
                unset($menu['url']['route']);
                $menu['params'] = $menu['url'];
                $menu['url'] =  Yii::app()->createUrl($menu['route'], $menu['params']);
                $menu['active'] = $menu['route'] == $this->route;
            }
            else {
                $menu['active'] = trim($menu['url'], '/') == trim(Yii::app()->request->url, '/');
            }
            if (is_array($menu['items'])) {
                $menu['items'] = $this->getPreparedMenu($menu['items']);
                if (!$menu['active']) {
                    foreach ($menu['items'] as $item) {
                        if ($item['active']) {
                            $menu['active'] = true;
                            break;
                        }
                    }
                }
            }
        }

        return $menus;
    }

    public function beforeAction($action) {

        $this->route = $this->getId().'/'.$this->getAction()->getId();

        return parent::beforeAction($action);
    }

    public function renderAjax($result, $error = false, $message = false, $redirect = false)
    {
        if (!Yii::app()->getRequest()->getIsAjaxRequest())
            $this->redirect(self::NOT_AJAX_REDIRECT);

        if(is_array($redirect)) {
            $route = isset($redirect[0]) ? $redirect[0] : '';
            $redirect = $this->createUrl($route, array_splice($redirect, 1));
        }
        if (is_array($error)) {
            $tmp = '<ul>';
            foreach ($error as $err) {
                if (is_array($err))
                    foreach ($err as $er)
                        $tmp .= '<li>'.htmlspecialchars($er).'</li>';
                else
                    $tmp .= '<li>'.htmlspecialchars($err).'</li>';
            }

            $tmp .= '</ul>';
            $error = $tmp;
        }

        $data = array(
            'error' => $error,
            'result' => $result,
            'message' => $message,
            'redirect' => $redirect
        );

        echo CJavaScript::jsonEncode($data);
        Yii::app()->end();

        return true;
    }

    public function renderAjaxError($error = null) {
        $this->renderAjax(false, !empty($error) ? $error : Yii::t('app', 'Your request is invalid.'));
        return true;
    }

    public function renderAjaxMessage($message) {
        $this->renderAjax(false, false, $message);
        return true;
    }

    public function renderAjaxModel($model, $result = null)
    {
        if (empty($model))
            return $this->renderAjaxError();
        else
            return $this->renderAjax(
                ($result === null ? $model->validate() : $result),
                ($model->hasErrors() ? $model->getErrors() : false));
    }

    public function renderCleanAjax($result)
    {
        if (!Yii::app()->getRequest()->getIsAjaxRequest())
            $this->redirect(self::NOT_AJAX_REDIRECT);

        echo CJavaScript::jsonEncode($result);
        Yii::app()->end();

        return true;
    }

    public function redirect($url, $terminate = true, $statusCode = 302)
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest())
            $this->renderAjax(false, false, false, $url);
        else
            parent::redirect($url, $terminate, $statusCode);

        return null;
    }

    public function setPageDescription($description) {
        $this->pageDescription = $description;
    }
}