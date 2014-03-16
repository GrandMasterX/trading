<?php
/**
 * @property Unit $unit
 *
 */
class ControllerFrontAccount extends ControllerFrontEnd
{
    public $layout = '//layouts/index';

    public $user;
    public $page;
    public $access;

    public $periodNotActive;
    public $activePeriod;
    public $currentPeriod;
    public $periods;

    public $unit;
    public $parent;
    public $units;

    public $tabMenu = array();

    public $menu = array(
        'unit' => array('label' => 'Business Units/Functions', 'url' => array('unit/index'), 'items' => array(
            array('url' => array('unit/view')),
            array('url' => array('unit/goals')),
            array('url' => array('unit/strategies')),
            array('url' => array('unit/strategy')),
            array('url' => array('unit/initiative')),
            array('url' => array('unit/members')),
        )),
        'calendar' => array('label' => 'Calendar', 'url' => array('calendar/index'), 'items' => array(
            array('url' => array('calendar/day')),
            array('url' => array('calendar/list'))
        )),
        'reports' => array('label' => 'Reports', 'url' => array('report/index'), 'items' => array(
            array('url' => array('report/view')),
        )),
        'members' => array('label' => 'Members', 'url' => array('member/index'), 'items' => array(
            array('url' => array('member/view')),
            array('url' => array('member/activity')),
            array('url' => array('member/profile')),
            array('url' => array('member/settings'))
        )),
        'activity' => array('label' => 'Activity', 'url' => array('activity/index')),
        //'permission' => array('label' => 'Permission', 'url' => array('permission/index')),
    );

    public function beforeAction($view)
    {
        // Check user session
        /*$lastActivity = Session::model()->lastActivity(Yii::app()->user->getId());

        if ($lastActivity < time() - 60 * 60)
        {
            $this->redirect(array('site/logout'));
        }
        else
        {
            Session::model()->updateSession(Yii::app()->user->getId());
        }

        $this->user = User::model()->findByPk(Yii::app()->user->getId());
        $this->page = Yii::app()->controller->id;

        $this->currentPeriod = Period::model()->getCurrentPeriod();
        $this->activePeriod = Period::model()->getActivePeriod();
        $this->periods = Period::model()->findAll(array('order' => 'start DESC'));
        $this->periodNotActive = ($this->currentPeriod['id'] != $this->activePeriod['id']);

        // Set up periods
        if (count($this->periods) == 0 && strpos(Yii::app()->request->url, 'period/') === false)
            $this->redirect('/period/manage/');
        */
        return parent::beforeAction($view);
    }

    protected function processUnit($id)
    {
        $this->unit = Unit::model()->findByPk($id);

        if (empty($this->unit))
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));

        $this->parent = $this->unit->parent()->find();
        $this->units = Unit::model()->findAll();

        // Check user's access permissions
        $this->access = Acl::model()->checkBasicPermissions(Yii::app()->user->getId(), $id);

        // Check extended access
        $extended_access = Acl::model()->checkExtendedPermissions(Yii::app()->user->getId(), 'unit', $id);
        if ($extended_access) $this->access = ($extended_access != 'forbid') ? $extended_access : false;

        $this->tabMenu = $this->getPreparedMenu(
            array(
                'overview' => array('label' => 'Overview', 'url' => array('unit/view', 'id' => $this->unit->id)),
                'goals' => array('label' => 'Goals', 'url' => array('unit/goals', 'id' => $this->unit->id)),
                'strategies' => array('label' => 'Strategies', 'url' => array('unit/strategies', 'id' => $this->unit->id), 'items' => array(array('url' => array('unit/strategy')), array('url' => array('unit/initiative')))),
                'members' => array('label' => 'Team', 'url' => array('unit/members', 'id' => $this->unit->id)),
            )
        );

        // Generate breadcrumbs
        $breadcrumbs[Yii::t('app', 'Business Units')] = array('unit/index');

        $ancestors = $this->unit->ancestors()->findAll();

        if (!empty($ancestors))
        {
            foreach ($ancestors as $a)
                $breadcrumbs[$a->name] = array('unit/view', 'id' => $a->id);
        }

        $breadcrumbs[] = $this->unit->name;

        $this->breadcrumbs = $breadcrumbs;
    }

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

    public function multiexplode ($delimiters,$string) {

        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return  $launch;
    }
}