<script>
document.addEventListener('turbo:load', () => {
    const source = document.getElementById('source');
    const code = document.getElementById('code');
    const category = document.getElementById('category');

    if (source && source.value === '5') {
        source.disabled = true;
        code.disabled = true;
    } else {
        category.disabled = true;
    }
})
</script>
