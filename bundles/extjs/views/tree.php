<?php $records=$model::all(); ?>

<?php
function get_children($record, $model) {
if ($children = $model::where('parent_id', '=', $record->id)->get())
{
    echo 'children: [';
    foreach ($children as $child) {
    echo '{';
    echo "text: '$child->name' ,";
    echo "leaf: "; if($child->is_leaf) echo 'true'; else echo 'false'; echo ',';
    get_children($child, $model);
    echo '},';
    }
    echo ']';
}
else return false;
}
?>

<script>
Ext.onReady(function() {
Ext.create('Ext.tree.Panel', {
    renderTo: Ext.getBody(),
    title: '<?php echo $model ?> Tree',
    width: 200,
    height: 300,
    root: {
        text: '<?php echo $model?>',     //'Root',
        expanded: true,      
        children: [
            <?php foreach($records as $record): ?>                      
                            <?php if($record->parent_id == 0 ): ?>
                                    {
                                    text: '<?php echo $record->name ?>',
                                    leaf: <?php if($record->is_leaf) echo 'true'; else echo 'false'; ?>,
                                    <?php get_children($record, $model) ?>
                                     },
                            <?php endif; ?>                      
            <?php endforeach; ?>            
        ]
    }
});

});
</script>
