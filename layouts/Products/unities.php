<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Products/unities.js']);

?>

%{header}%
<header class="modbar">
    <div class="buttons">
        <fieldset class="fields-group big">
            <div class="compound st-4-left">
                <span><i class="fas fa-search"></i></span>
                <input type="text" data-search="products_unities" placeholder="{$lang.search}">
            </div>
        </fieldset>
        <!-- <?php if (Permissions::user(['create_products_unities']) == true) : ?>
            <a data-action="create_product_unity" class="success"><i class="fas fa-plus"></i><span>{$lang.create}</span></a>
        <?php endif; ?> -->
    </div>
</header>
<main class="workspace">
    <table class="tbl-st-1" data-table="products_unities">
        <tbody>
            <?php foreach ($data['products_unities'] as $value) : ?>
                <tr>
                    <td class="mediumtag">
                        <span><?php echo (($value['system'] == true) ? $value['name'][Session::get_value('vkye_account')['language']] : $value['name']); ?></span>
                    </td>
                    <td></td>
                    <?php if (Permissions::user(['block_products_unities','unblock_products_unities']) == true) : ?>
                        <td class="button">
                            <?php if ($value['system'] == false) : ?>
                                <?php if ($value['blocked'] == true) : ?>
                                    <a data-action="unblock_product_unity" data-id="<?php echo $value['id']; ?>"><i class="fas fa-lock"></i><span>{$lang.unblock}</span></a>
                                <?php elseif ($value['blocked'] == false) : ?>
                                    <a data-action="block_product_unity" data-id="<?php echo $value['id']; ?>"><i class="fas fa-unlock"></i><span>{$lang.block}</span></a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
                    <?php if (Permissions::user(['delete_products_unities']) == true) : ?>
                        <td class="button">
                            <?php if ($value['system'] == false) : ?>
                                <?php if ($value['blocked'] == false) : ?>
                                    <a data-action="delete_product_unity" data-id="<?php echo $value['id']; ?>" class="alert"><i class="fas fa-trash"></i><span>{$lang.delete}</span></a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
                    <?php if (Permissions::user(['update_products_unities']) == true) : ?>
                        <td class="button">
                            <?php if ($value['system'] == false) : ?>
                                <?php if ($value['blocked'] == false) : ?>
                                    <a data-action="update_product_unity" data-id="<?php echo $value['id']; ?>" class="warning"><i class="fas fa-pen"></i><span>{$lang.update}</span></a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
<?php if (Permissions::user(['create_products_unities','update_products_unities']) == true) : ?>
    <section class="modal" data-modal="create_product_unity">
        <div class="content">
            <main>
                <form>
                    <fieldset class="fields-group">
                        <div class="text">
                            <input type="text" name="name" placeholder="{$lang.type}">
                        </div>
                        <div class="title">
                            <h6>{$lang.name}</h6>
                        </div>
                    </fieldset>
                    <fieldset class="fields-group">
                        <div class="button">
                            <a class="alert" button-close><i class="fas fa-times"></i></a>
                            <button type="submit" class="success"><i class="fas fa-check"></i></button>
                        </div>
                    </fieldset>
                </form>
            </main>
        </div>
    </section>
<?php endif; ?>
<?php if (Permissions::user(['delete_products_unities']) == true) : ?>
    <section class="modal alert" data-modal="delete_product_unity">
        <div class="content">
            <main>
                <i class="fas fa-trash"></i>
                <div>
                    <a button-close><i class="fas fa-times"></i></a>
                    <a button-success><i class="fas fa-check"></i></a>
                </div>
            </main>
        </div>
    </section>
<?php endif; ?>
