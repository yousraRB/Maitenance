<div class='pagination'>
        <?php
        if ($total_pages > 1) {
            if ($current_page > 1) {
                echo "<a href='?page=" . ($current_page - 1) . "'>&laquo; Previous</a>";
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $current_page) {
                    echo "<span class='current-page'>$i</span>";
                } else {
                    echo "<a href='?page=$i'>$i</a>";
                }
            }
            if ($current_page < $total_pages) {
                echo "<a href='?page=" . ($current_page + 1) . "'>Next &raquo;</a>";
            }
        }
        ?>
        <div class="n-p">
      <!-- Previous button -->
<form action="" method="get" style="display: inline;">
    <input type="hidden" name="page" value="<?php echo ($current_page - 1); ?>">
    <input type="hidden" name="titre" value="<?php echo $search_name; ?>">
    <button type="submit" <?php if ($current_page <= 1) echo "disabled"; ?>>&laquo; Précédent</button>
</form>

<!-- Next button -->
<form action="" method="get" style="display: inline;">
    <input type="hidden" name="page" value="<?php echo ($current_page + 1); ?>">
    <input type="hidden" name="titre" value="<?php echo $search_name; ?>">
    <button type="submit">Suivant &raquo;</button>
</form>
</div>
    </div>