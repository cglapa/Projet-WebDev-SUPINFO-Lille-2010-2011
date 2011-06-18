<?php
require_once('config.php');
require_once('autoload.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <script type="text/javascript" src="jquery-1.6.1.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#customer_id").blur(function(){
                    if($(this).val() == "") {
                        $("#customer_name").text("Aucune référence client entrée");
                    } else {
                        $("#customer_name").html("<img src=\"media/loading.gif\" alt=\"Chargement...\" />");
                        $.ajax({
                            type: "POST",
                            url: "loanAjax.php",
                            data: "action=search&type=customer&id="+$(this).val(),
                            success: function(msg) {
                                $("#customer_name").text(msg);
                            }
                        })
                    }
                });
                $("#lastline").live('focus',function() {
                    $(this).removeAttr("id");
                    $("#table_body").append("\n\
                        <tr id=\"lastline\">\n\
                            <td><input type=\"text\" name=\"article_id[]\" size=\"5\" class=\"article_id\" /></td>\n\
                            <td><input type=\"text\" class=\"article_name\" size=\"50\" disabled=\"disabled\" /></td>\n\
                            <td><input type=\"text\" name=\"article_qty[]\" size=\"2\" /></td>\n\
                            <td><input type=\"checkbox\" name=\"article_date[]\" class=\"article_date\" /><input type=\"text\" name=\"article_date_begin[]\" class=\"article_date_begin\" size=\"10\" disabled=\"disabled\" /> - <input type=\"text\" name=\"article_date_end[]\" class=\"article_date_end\" size=\"10\" disabled=\"disabled\" /></td>\n\
                        </tr>");
                });
                $(".article_id").live('blur',function(){
                    var id = $(".article_id").index(this);
                    if($(this).val() != "") {
                        $($(".article_name")[id]).attr("value", "Recherche de l'article...");
                        $.ajax({
                            type: "POST",
                            url: "loanAjax.php",
                            data: "action=search&type=article&id="+$(this).val(),
                            success: function(msg) {
                                $($(".article_name")[id]).val(msg);
                            }
                        })
                    } else {
                        $($(".article_name")[id]).val("");
                    }
                });
                $(".article_date").live('change',function(){
                    var id = $(".article_date").index(this);
                    if($(this).attr("checked")) {
                        $($(".article_date_begin")[id]).removeAttr("disabled");
                        $($(".article_date_end")[id]).removeAttr("disabled");
                    } else {
                        $($(".article_date_begin")[id]).attr("disabled","disabled");
                        $($(".article_date_end")[id]).attr("disabled","disabled");
                    }
                })
            })
        </script>
    </head>
<?php if(isset($_GET['id'])): ?>

<?php else: ?>
    <body>
        <form method="POST" action="editLoan.php">
            <table>
                <tr><td>Référence client</td><td><input type="text" name="customer" size="6" id="customer_id" /> - <span id="customer_name">Aucune référence client entrée</span></td></tr>
                <tr><td>Période</td><td>du <input type="text" name="date_begin" size="10" /> au <input type="text" name="date_end" size="10" /></td></tr>
                <tr><td>Motif du prêt</td><td><input type="text" name="reason" size="100" /></td></tr>
                <tr>
                    <td colspan="2">
                        <table>
                            <thead>
                                <td>Référence</td>
                                <td>Dénomination</td>
                                <td>Qté</td>
                                <td>Période (optionnel)</td>
                            </thead>
                            <tbody id="table_body">
                                <tr id="lastline">
                                    <td><input type="text" name="article_id[]" size="5" class="article_id" /></td>
                                    <td><input type="text" class="article_name" size="50" disabled="disabled" /></td>
                                    <td><input type="text" name="article_qty[]" size="2" /></td>
                                    <td><input type="checkbox" name="article_date[]" class="article_date" /><input type="text" name="article_date_begin[]" class="article_date_begin" size="10" disabled="disabled" /> - <input type="text" name="article_date_end[]" class="article_date_end" size="10" disabled="disabled" /></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr><td><input type="submit" value="Ajouter" /></td></tr>
            </table>
        </form>
    </body>
<?php endif; ?>
</html>