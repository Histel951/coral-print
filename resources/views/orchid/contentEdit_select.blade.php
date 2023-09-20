<input type="hidden" id="calcs" value="{{$calcs}}">
<script>
    {
        document.addEventListener('turbo:load', () => {
            const calcs = JSON.parse(document.getElementById('calcs')?.value || '{}');
            const calcTypeSelect = document.getElementById('calc_type');
            const defaultCalcSelect = document.getElementById('default_calculator_id');

            if (!calcTypeSelect) return;

            calcTypeSelect.addEventListener('change', () => {
                const typeValue = +calcTypeSelect.options[calcTypeSelect.selectedIndex].value
                defaultCalcSelect.innerHTML = '';
                for (const key in calcs[typeValue]) {
                    defaultCalcSelect.append(new Option(calcs[typeValue][key].name, calcs[typeValue][key].id))
                }
            })
        })
    }
</script>