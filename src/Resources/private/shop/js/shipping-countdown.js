import jQuery from 'jquery';

(($) => {
  $.fn.extend({
    setonoShippingCountdown() {
      let endDate;
      const $widget = $(this);
      const nextShipmentDate = $widget.attr('data-next-shipment-date');

      if ('' !== nextShipmentDate) {
        endDate = Date.parse(nextShipmentDate);
        if (endDate) {
          $widget.attr('style', '');
          setInterval(calculate, 1000);
          calculate();
        }
      }

      function calculate() {
        let days;
        let hours;
        let minutes;
        let seconds;

        let startDate = new Date();
        startDate = startDate.getTime();

        let timeRemaining = parseInt((endDate - startDate) / 1000, 10);
        if (timeRemaining >= 0) {
          days = parseInt(timeRemaining / 86400, 10);
          timeRemaining %= 86400;

          hours = parseInt(timeRemaining / 3600, 10);
          timeRemaining %= 3600;

          minutes = parseInt(timeRemaining / 60, 10);
          timeRemaining %= 60;

          seconds = parseInt(timeRemaining, 10);

          const $daysElement = $widget.find('.days');
          if (days > 0) {
            $daysElement.text(days);
            $daysElement.parent().attr('style', '');
          } else {
            $daysElement.parent().attr('style', 'display: none');
          }
          $widget.find('.hours').text((`0${hours}`).slice(-2));
          $widget.find('.minutes').text((`0${minutes}`).slice(-2));
          $widget.find('.seconds').text((`0${seconds}`).slice(-2));
        }
      }
    },
  });
})(jQuery);
