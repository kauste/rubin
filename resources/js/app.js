 import * as bootstrap from 'bootstrap';
import axios from 'axios';
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const cartUpdate = () => {
    axios.get(showNavCartUrl)
    .then(res =>{
        document.querySelector('.nav--cart').innerHTML = res.data.html;
    })
 }
 window.addEventListener('load', () => {
    cartUpdate();
    if(document.querySelector('.message--javascript.message')){
        const msg = document.querySelector('.message--javascript');
        msg.classList.remove('message');
        msg.innerText ='';
    }
    
 })
 document.querySelectorAll('.add--to--cart')
 .forEach(button => {
    button.addEventListener('click', ()=>{
    const form = button.closest('thead');
    const masterId = document.querySelector('[name=master_id]').value;
    const appointment = {
        'procedureId':form.querySelector('.procedure--id').dataset.procedureId,
        'year': form.querySelector('.appointment--year').value,
        'month': form.querySelector('.appointment--month').value,
        'day': form.querySelector('.appointment--day').value,
        'hour': form.querySelector('.appointment--hour').value,
        'minute': form.querySelector('.appointment--minute').value,
    }
    axios.post(addToCartUrl, {masterId, appointment})
    .then(res => {
        const msg = document.querySelector('.message--javascript');
        msg.classList.add('message');
        msg.innerText = res.data.message;
         cartUpdate();
        })
    })
 })
 if(document.querySelector('.order--appointments')){
    document.querySelector('.order--appointments')
    .addEventListener('click', () => {
        const oneAppointment = document.querySelectorAll('.one--appointment');
        const appointments = [];
        oneAppointment.forEach(appointm =>{
            const masterId =document.querySelector('.master--id');
            const procedureId =document.querySelector('.procedure--id');
            const appointment = {
                'masterId': masterId.dataset.masterId,
                'procedureId': procedureId.dataset.procedureId,
                'appoitmentDate': { 'start': appointm.querySelector('.appointment--start').innerText,
                                    'end': appointm.querySelector('.appointment--end').innerText,
                                  },
            };
            appointments.push(appointment);
            })
            axios.post(makeOrderUrl, {appointments})
            .then(res => {
                const msg = document.querySelector('.message--javascript');
                msg.classList.add('message');
                document.location.reload();
                msg.innerText = res.data.message;
        })

    });
 }

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