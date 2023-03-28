var slider = document.getElementById("slider");

noUiSlider.create(slider, {
  start: [5, 20],
  connect: true,
  tooltips: true,
  range: {
    min: 0,
    max: 30,
  },
  format: {
    from: function (value) {
      return parseInt(value);
    },
    to: function (value) {
      return parseInt(value);
    },
  },
});
