document.addEventListener("DOMContentLoaded", () => {
    const round = document.querySelector('.round');
    const roundRadius = +round.querySelector('circle').getAttribute("r");
    const roundPercent = +round.getAttribute('data-percent');
    const roundCircum = 2 * roundRadius * Math.PI;
    const roundDraw = roundPercent * roundCircum / 100;
    round.style.strokeDasharray = roundDraw + '999';
});