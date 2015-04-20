<?php

/**
 * OpenCart Ukrainian Community
 * Made in Ukraine
 *
 * LICENSE
 *
 * This source file is subject to the GNU General Public License, Version 3
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/copyleft/gpl.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 *
 * @category   OpenCart
 * @package    OCU Nova Poshta
 * @copyright  Copyright (c) 2011 Eugene Lifescale (a.k.a. Shaman) by OpenCart Ukrainian Community (http://opencart-ukraine.tumblr.com)
 * @license    http://www.gnu.org/copyleft/gpl.html     GNU General Public License, Version 3
 * @version    $Id: catalog/model/shipping/ocu_ukrposhta.php 1.2 2014-12-27 19:18:40
 */
/**
 * @category   OpenCart
 * @package    OCU OCU Nova Poshta
 * @copyright  Copyright (c) 2011 Eugene Lifescale (a.k.a. Shaman) by OpenCart Ukrainian Community (http://opencart-ukraine.tumblr.com)
 * @license    http://www.gnu.org/copyleft/gpl.html     GNU General Public License, Version 3
 */

 ?>


<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a
                href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/shipping.png" alt=""/> <?php echo $heading_title; ?></h1>

            <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a
                        onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
            </div>
        </div>
        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <table class="form">
                    <tr>
                        <td><?php echo $entry_api_key; ?></td>
                        <td><input type="text" name="novaposhta_api_key" value="<?php echo $novaposhta_api_key; ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_sender_organization; ?></td>
                        <td><input type="text" name="novaposhta_sender_organization"
                                   value="<?php echo $novaposhta_sender_organization; ?>"/></td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_sender_person; ?></td>
                        <td><input type="text" name="novaposhta_sender_person"
                                   value="<?php echo $novaposhta_sender_person; ?>"/></td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_sender_phone; ?></td>
                        <td><input type="text" name="novaposhta_sender_phone"
                                   value="<?php echo $novaposhta_sender_phone; ?>"/></td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_sender_city; ?></td>
                        <td id="novaposhta_sender_city">Loading...</td>
                        <div id="novaposhta_sender_city_name"></div>
                    </tr>
                    <tr>
                        <td><?php echo $entry_sender_warehouse; ?></td>
                        <td id="novaposhta_sender_warehouse">Loading...</td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_geo_zone; ?></td>
                        <td><select name="novaposhta_geo_zone_id">
                                <option value="0"><?php echo $text_all_zones; ?></option>
                                <?php foreach ($geo_zones as $geo_zone) { ?>
                                <?php if ($geo_zone['geo_zone_id'] == $novaposhta_geo_zone_id) { ?>
                                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"
                                        selected="selected"><?php echo $geo_zone['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select></td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_send_order_status; ?></td>
                        <td><select name="novaposhta_send_order_status">
                                <option value="0"><?php echo $text_select; ?></option>
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $novaposhta_send_order_status) { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"
                                        selected="selected"><?php echo $order_status['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select></td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_status; ?></td>
                        <td><select name="novaposhta_status">
                                <?php if ($novaposhta_status) { ?>
                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_enabled; ?></option>
                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select></td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_sort_order; ?></td>
                        <td><input type="text" name="novaposhta_sort_order"
                                   value="<?php echo $novaposhta_sort_order; ?>" size="1"/></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<?php
    $senderSity = "";
    if (isset($novaposhta_sender_city_name) && $novaposhta_sender_city_name != "") {
        $senderSity = $novaposhta_sender_city_name;
    } else {
        $senderSity = $novaposhta_sender_city;
    }
    ?>
<script type="text/javascript"><!--

    function getCities() {

        $.ajax({
            url: 'index.php?route=shipping/novaposhta/getCities&token=<?php echo $token; ?>&filter=' + encodeURIComponent('<?php echo $novaposhta_sender_city; ?>'),
            dataType: 'json',
            success: function (json) {
                var inputHTMl;
                html = '<select name="novaposhta_sender_city">';
                html += '<option value=""><?php echo $text_select; ?></option>';
                for (i = 0; i < json.length; i++) {
                    if (json[i]['city'] == '<?php echo $novaposhta_sender_city_name; ?>') {
                        html += '<option selected="selected" value="' + json[i]['ref'] + '">' + json[i]['city'] + '</option>';
                    } else {
                        html += '<option value="' + json[i]['ref'] + '">' + json[i]['city'] + '</option>';
                    }
                    inputHTMl = '<input name="novaposhta_sender_city_name" type="hidden" value="' + json[i]['city'] + '">';
                }
                html += '</select>';


                $('#novaposhta_sender_city').html(html);
                $('#novaposhta_sender_city_name').html(inputHTMl);
            }
        });
    }

    function getWarehouses() {
        var senderSelect = $('#novaposhta_sender_city select');
        var senderSelected = $('#novaposhta_sender_city option:selected');
        var senderCity = senderSelect.val();
        var senderSelectedText = senderSelected.text();
        var url = 'index.php?route=shipping/novaposhta/getWarehouses&token=<?php echo $token; ?>&filter=' + encodeURIComponent('<?php echo $novaposhta_sender_city; ?>');
        if (senderCity !== undefined) {
            url = 'index.php?route=shipping/novaposhta/getWarehouses&token=<?php echo $token; ?>&filter=' + senderCity;
            var inputHTMl = '<input name="novaposhta_sender_city_name" type="hidden" value="' + senderSelectedText + '">';
            $('#novaposhta_sender_city_name').html(inputHTMl);
        }
        console.log(url);
        $.ajax({
            url: url,
            dataType: 'json',
            success: function (json) {

                html = '<select name="novaposhta_sender_warehouse">';

                html += '<option value=""><?php echo $text_select; ?></option>';
                for (i = 0; i < json.length; i++) {
                    if (json[i]['warehouse'] == '<?php echo $novaposhta_sender_warehouse; ?>') {
                        html += '<option selected="selected" value="' + json[i]['warehouse'] + '">' + json[i]['warehouse'] + '</option>';
                    } else {
                        html += '<option value="' + json[i]['warehouse'] + '">' + json[i]['warehouse'] + '</option>';
                    }
                }
                html += '</select>';

                $('#novaposhta_sender_warehouse').html(html);
            }
        });
    }

    $(document).ready(function () {
        getCities();
        getWarehouses();
    });

    $('#novaposhta_sender_city').change(function () {
        $('#novaposhta_sender_warehouse').html('Loading...');
        getWarehouses();
    });

    //--></script>

<?php echo $footer; ?>
