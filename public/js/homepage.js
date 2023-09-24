
function updateCounter() {
  const counters = document.querySelectorAll('.stat-number');
  const speed = 5000000000000000;

  counters.forEach( counter => {
    const animate = () => {
      const value = +counter.getAttribute('value');
      const data = +counter.innerText;
      
      const time = value / speed;
      if(data < value) {
        counter.innerText = Math.ceil(data + time);
        setTimeout(animate, 60);
      } else{
        counter.innerText = value;
      }
    }
   
    animate();
  });
}

document.addEventListener("DOMContentLoaded", (event) => {
  updateCounter()
});