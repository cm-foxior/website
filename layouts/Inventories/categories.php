<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Inventories/categories.min.js']);

?>

%{header}%
<header class="modbar">
    <?php if (Permissions::user(['inventories'], true) == true) : ?>
    <a href="/inventories" class="unfocus"><i class="fas fa-box-open"></i><span>{$lang.inventories}</span></a>
    <span></span>
    <?php endif; ?>
    <?php if (Permissions::user(['inventories_types'], true) == true) : ?>
    <a href="/inventories/types" class="unfocus"><i class="fas fa-bookmark"></i><span>{$lang.types}</span></a>
    <?php endif; ?>
    <?php if (Permissions::user(['inventories_locations'], true) == true) : ?>
    <a href="/inventories/locations" class="unfocus"><i class="fas fa-map-marker-alt"></i><span>{$lang.locations}</span></a>
    <?php endif; ?>
    <a href="/inventories/categories"><i class="fas fa-tag"></i><span>{$lang.categories}</span></a>
    <span></span>
    <?php if (Permissions::user(['create_inventories_categories']) == true) : ?>
    <a data-action="create_inventory_category" class="success"><i class="fas fa-plus"></i><span>{$lang.create}</span></a>
    <?php endif; ?>
    <fieldset class="fields-group">
        <div class="compound st-4-left">
            <span><i class="fas fa-search"></i></span>
            <input type="text" data-search="inventories_categories" placeholder="{$lang.search}">
        </div>
    </fieldset>
</header>
<main>
    <table class="tbl-st-1" data-table="inventories_categories">
        <tbody>
            <?php foreach ($data['inventories_categories'] as $value) : ?>
            <tr>
                <td class="smalltag"><span>{$lang.level} <?php echo $value['level']; ?></span></td>
                <td><?php echo $value['name']; ?></td>
                <td class="smalltag">
                    <?php if ($value['blocked'] == true) : ?>
                    <span class="busy">{$lang.blocked}</span>
                    <?php elseif ($value['blocked'] == false) : ?>
                    <span>{$lang.unblocked}</span>
                    <?php endif; ?>
                </td>
                <?php if (Permissions::user(['block_inventories_categories','unblock_inventories_categories']) == true) : ?>
                <td class="button">
                    <?php if ($value['blocked'] == true) : ?>
                    <a data-action="unblock_inventory_category" data-id="<?php echo $value['id']; ?>"><i class="fas fa-lock-open"></i><span>{$lang.unblock}</span></a>
                    <?php elseif ($value['blocked'] == false) : ?>
                    <a data-action="block_inventory_category" data-id="<?php echo $value['id']; ?>"><i class="fas fa-lock"></i><span>{$lang.block}</span></a>
                    <?php endif; ?>
                </td>
                <?php endif; ?>
                <?php if (Permissions::user(['delete_inventories_categories']) == true) : ?>
                <td class="button">
                    <?php if ($value['blocked'] == false) : ?>
                    <a data-action="delete_inventory_category" data-id="<?php echo $value['id']; ?>" class="alert"><i class="fas fa-trash"></i><span>{$lang.delete}</span></a>
                    <?php endif; ?>
                </td>
                <?php endif; ?>
                <?php if (Permissions::user(['update_inventories_categories']) == true) : ?>
                <td class="button">
                    <?php if ($value['blocked'] == false) : ?>
                    <a data-action="update_inventory_category" data-id="<?php echo $value['id']; ?>" class="warning"><i class="fas fa-pen"></i><span>{$lang.update}</span></a>
                    <?php endif; ?>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
<?php if (Permissions::user(['create_inventories_categories','update_inventories_categories']) == true) : ?>
<section class="modal" data-modal="create_inventory_category">
    <div class="content">
        <main>
            <form>
                <fieldset class="fields-group">
                    <div class="row">
                        <div class="span8">
                            <div class="text">
                                <input type="text" name="name" placeholder="{$lang.name}">
                            </div>
                        </div>
                        <div class="span4">
                            <div class="text">
                                <input type="text" name="level" placeholder="{$lang.level}">
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="fields-group">
                    <div class="button">
                        <button type="submit" class="success"><i class="fas fa-plus"></i></button>
                        <a class="alert" button-close><i class="fas fa-times"></i></a>
                    </div>
                </fieldset>
            </form>
        </main>
    </div>
</section>
<?php endif; ?>
<?php if (Permissions::user(['delete_inventories_categories']) == true) : ?>
<section class="modal alert" data-modal="delete_inventory_category">
    <div class="content">
        <main>
            <i class="fas fa-trash"></i>
            <div>
                <a button-success><i class="fas fa-check"></i></a>
                <a button-close><i class="fas fa-times"></i></a>
            </div>
        </main>
    </div>
</section>
<?php endif; ?>