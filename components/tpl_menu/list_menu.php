
<li>
    <a href="<?= \yii\helpers\Url::to(['category/view', 'id' => $cat['id']]); ?>"><?=$cat['name'];?></a>
    <?php if(isset($cat['child'])) : ?>
        <span class="badge pull-right"><i class="fa fa-plus"></i></span>
        <ul>
            <?= $this->getHtmlMenu($cat['child']); ?>
        </ul>    
    <?php endif; ?>
</li>
