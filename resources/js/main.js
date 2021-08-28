const priceRangeSlider = (function($) {
    const dom = {
        rangeSlider: document.querySelector("#rangeSlider"),
        rangeSliderValue: document.querySelector("#rangeSliderValue"),
        rangeSliderPriceRange: document.querySelector("#rangeSliderPriceRange"),
        rangeSliderMin: parseInt(rangeSlider.getAttribute("data-min")),
        rangeSliderMax: parseInt(rangeSlider.getAttribute("data-max"))
    };

    let selectedMin = 0;
    let selectedMax = 0;

    const setMinMax = (function() {
        const getCurrentMinMax = dom.rangeSliderPriceRange.value.split("-");
        const currentMinMax = getCurrentMinMax.map(function(item) {
            return parseInt(item);
        });

        if (currentMinMax[0] != dom.rangeSliderMin || currentMinMax[1] != dom.rangeSliderMax) {
            console.log("using NEW min max");
            selectedMin = currentMinMax[0];
            selectedMax = currentMinMax[1];
        } else {
            console.log("Using DEFAULT min max");
            selectedMin = dom.rangeSliderMin;
            selectedMax = dom.rangeSliderMax;
        }
    })();
    
    $(rangeSlider).slider({
        range: true,
        min: dom.rangeSliderMin,
        max: dom.rangeSliderMax,
        step: 50000,
        values: [selectedMin, selectedMax],
        slide: function(event, ui) {
            dom.rangeSliderPriceRange.value = `${ui.values[0]}-${ui.values[1]}`;
            console.log(ui);
            dom.rangeSliderValue.innerHTML = `$${ui.values[0].toLocaleString()} TO $${ui.values[1].toLocaleString()}`;
        }
    });

    dom.rangeSliderValue.innerHTML = `$${$(rangeSlider).slider("values", 0).toLocaleString()} TO $${$(rangeSlider).slider("values", 1).toLocaleString()}`;
})(jQuery);