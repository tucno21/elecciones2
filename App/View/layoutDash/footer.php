<?php include ext('layoutDash.menuDash') ?>


<footer class="footer-admin mt-auto footer-light">
    <div class="container-xl px-4">
        <div class="row">
            <div class="col-md-6 small">Copyright © ideasweb21 <?= date('Y') ?></div>
        </div>
    </div>
</footer>
</div>
</div>


<?php foreach ($linksScript as $value) : ?>
    <script src="<?= $value ?>"></script>
<?php endforeach; ?>

<?php if (isset($linksScript2)) : ?>
    <?php foreach ($linksScript2 as $value) : ?>
        <script src="<?= $value ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>

</html>