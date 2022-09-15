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
 if(document.querySelector('.procedure--chosen')){
     
     const procedureChosen = document.querySelector('.procedure--chosen');
     const backToProceduresBtn = document.querySelector('.back--to--procedures');
     procedureChosen.addEventListener('click', () => {
        const msg = document.querySelector('.message--javascript');
        const procedureId = document.querySelector('input[name="procedure"]:checked')?.value;
        const label = document.querySelector('label[for="' + procedureId + '"]');
        const serviceBox = document.querySelector('.service--box');
        const callendarBox = document.querySelector('.callendar--box');
        const callendarHeader = callendarBox.querySelector('h4>b');
        const callendarBtnBox= document.querySelector('.callendar--btn--box');
        if(procedureId == null){
            msg.classList.add('message');
            msg.innerText = 'You did not choose procedure. Please choose from the list.';
        } else{
            msg.innerText = '';
            msg.classList.remove('message');
            serviceBox.classList.add('d-none');
            callendarBox.classList.remove('d-none');
            callendarBtnBox.classList.remove('d-none');
            callendarBtnBox.classList.add('rating-form');
            callendarHeader.innerText = label.innerText;
        }
    });

    backToProceduresBtn.addEventListener('click', () => {
        const serviceBox = document.querySelector('.service--box');
        const callendarBox = document.querySelector('.callendar--box');
        const callendarHeader = callendarBox.querySelector('h4>b');
        const callendarBtnBox= document.querySelector('.callendar--btn--box');

        serviceBox.classList.remove('d-none');
        callendarBox.classList.add('d-none');
        callendarBtnBox.classList.add('d-none');
        callendarBtnBox.classList.remove('rating-form');
        callendarHeader.innerText = '';
    })

 }
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
                const date = b.dataset.timeData;
                const masterId = document.querySelector('[name="master_id"]').value;
                const procedureId = document.querySelector('input[name="procedure"]:checked').value;
                axios.post(dayUrl, {date, masterId, procedureId})
                .then(res => {           
                    document.querySelector('.day--appointments').innerHTML = res.data.html;
                    addToCart();
                })
            })
         })
        }
    const addToCart = () => {
        const addToCartBtn = document.querySelector('.add--to--cart');
        const masterId = document.querySelector('[name=master_id]').value;
        addToCartBtn.addEventListener('click', () => {
            const appintmentRadioBtn = document.querySelector('input[name="free-time"]:checked');
            const appointmenTime = appintmentRadioBtn.closest('thead');
            const appointment = {
                'procedureId': document.querySelector('input[name="procedure"]:checked').value,
                'dateTime': document.querySelector('.appointment--date').innerText + ' ' + appointmenTime.querySelector('.appointment--starts').innerText,
            }
            axios.post(addToCartUrl, {masterId, appointment})
           .then(res => {
            const msg = document.querySelector('.message--javascript');
            msg.classList.add('message');
            msg.innerText = res.data.message;
            cartUpdate();
           })
        })
    }
        
    window.addEventListener('load', () => {
        onNext();
        onPrevious();
        setDayEvents();
        
    })
 }

 if(document.querySelector('.rating--star')){
    const ratingStars = document.querySelectorAll('.rating--star');

    for(let i = 0; i < ratingStars.length; i++){
        for(let j = 0; j <= i; j++){
        ratingStars[i].addEventListener('mouseenter', ()=> {
                ratingStars[j].style.fill = 'yellow';
            })
            ratingStars[i].addEventListener('mouseleave', ()=> {
                ratingStars[j].style.fill = 'white';
            })
        }
    }
        
    ratingStars.forEach((ratingStar) => {
        ratingStar.addEventListener('click', () => {
            const rating = ratingStar.dataset.rating;
            const masterId = document.querySelector("[name='master_id']").value;
            axios.post(rateUrl, {rating, masterId})
            .then(res => {
                const ratingNum = document.querySelector('.rating--sum>b');
                const msg = document.querySelector('.message--javascript');
                ratingNum.innerText = res.data.newRating;
                msg.classList.add('message');
                msg.innerText = res.data.message;
            })
        })
    })
   
 }