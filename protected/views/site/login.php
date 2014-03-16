<div class="form-outer-holder">
    <div class="l-form-holder">
        <div class="login-form-holder">
            <h2>Login form</h2>
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'login-form',
                'enableAjaxValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
                'htmlOptions'=>array(
                    'class'=>'form-horizontal'
                ),
            )); ?>

            <div class="control-group">
                <?php echo $form->labelEx($model,'email', array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'email'); ?>
                    <?php echo $form->error($model,'email'); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo $form->labelEx($model,'password', array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->passwordField($model,'password'); ?>
                    <?php echo $form->error($model,'password'); ?>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <?php echo CHtml::link(('Восстановление пароля'),'/restore',array('class'=>'restore-link'))?>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <?php echo CHtml::link(('Регистрация'),'/signup',array('class'=>'restore-link'))?>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <?php echo CHtml::submitButton(Yii::t('loginForm', 'Войти'),array('class'=>'btn')); ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
                </div>

                <div class="restore-pass-form-holder" style="display:none">
                </div>
            </div>
            <?php
            //$this->widget('ext.eauth.EAuthWidget', array('action' => 'site/login'));
            ?>
</div>