<footer
    class="mt-auto border-t border-gray-200 dark:border-gray-800 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p>&copy; {{ date('Y') }} GLPI Controle</p>
    </div>
</footer>

<script type="text/javascript">
    (function() {
        setInterval(function() {
            fetch('/session/getdate').then(response => response.json());
        }, 8 * 60 * 1000); // a cada 8 minutos (480000 ms)
    })();
</script>
</body>

</html>
