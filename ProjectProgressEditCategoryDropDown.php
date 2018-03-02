<?php
$category_p=queryMySql("SELECT distinct category_name,category.category_id FROM category
left join project_progress on category.category_id = project_progress.category_id where category.category_id = '$category_id'");

$not_category=queryMySql("SELECT distinct category_name,category.category_id FROM category
left join project_progress on category.category_id = project_progress.category_id where category.category_id != '$category_id'");

while($row_category=mysqli_fetch_array($category_p)){
?>

<select name = 'category_id' class ='browser-default'>
<option value="<?php echo "{$row_category['category_id']}";?>"><?php echo "{$row_category['category_name']}"; ?></option>

<?php
}
while($not_row_category=mysqli_fetch_array($not_category)){
?>
<option value="<?php echo "{$not_row_category['category_id']}";?>"><?php echo "{$not_row_category['category_name']}"; ?></option>

<?php
}
?>
</select>
<br><br>
