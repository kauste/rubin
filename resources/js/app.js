 import * as bootstrap from 'bootstrap';
import axios from 'axios';
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

 if(document.querySelector('.next--month')){
  
    const onNext = () => {
        const nextBtn = document.querySelector('.next--month')
        nextBtn.addEventListener('click', ()=>{
            const monthNow = document.querySelector('.now--month');
            const monthValue = monthNow.dataset.month;
            axios.post(nextMonthUrl, {monthValue})
            .then(res =>{
                document.querySelector('.callendar--include').innerHTML = res.data.html;
                onNext();
                onPrevious();
                setDayEvents();
            })
        });
    }

    const onPrevious = () => {
        const previousBtn = document.querySelector('.previous--month')
        previousBtn.addEventListener('click', ()=>{ 
            const monthNow = document.querySelector('.now--month');
            const monthValue = monthNow.dataset.month;
            console.log(monthValue);
            axios.post(previousMonthUrl, {monthValue})
            .then(res =>{
                document.querySelector('.callendar--include').innerHTML = res.data.html;
                onPrevious();
                onNext();
                setDayEvents();
            })
        });
    }
    const setDayEvents =() => {
        document.querySelectorAll('.week--day')
         .forEach(b => {
            b.addEventListener('click', () => {
                const data = b.dataset.timeData;
                axios.post(dayUrl, {data})
                .then(res => {           
                    document.querySelector('.day--appointments').innerHTML = res.data.html;
                })
            })
         })
        }
        
    window.addEventListener('load', () => {
        onNext();
        onPrevious();
        setDayEvents();
    })
     

 }