import axios from 'axios';
import 'bootstrap';
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
const cartBladeUrl = assetUrl + '/my-order';

const cartUpdate = () => {
    axios.get(showNavCartUrl)
    .then(res =>{
        document.querySelector('.nav--cart').innerHTML = res.data.html;
    })
 }
 const addMsg = text => {
    const msg = document.querySelector('.message--javascript');
    msg.classList.add('message');
    msg.innerText = text;
 }
 const addMsgs = array => {
    const msg = document.querySelector('.message--javascript');
    msg.classList.add('message','alert');
    let msgsHTML= '';
    array.forEach((msg)=>{
        msgsHTML += `<li class="list-group-item list-group-item-danger">${msg}</li>`;
    })
    msg.innerHTML = `
                    <ul class="list-group">
                    ${msgsHTML}
                    </ul>
                    `
 }

 const removeMsg = () => {
    const msg = document.querySelector('.message--javascript');
    msg.classList.remove('message');
    msg.innerText = '';
 }
 window.addEventListener('load', () => {
    if(document.querySelector('.nav--cart')){
        cartUpdate();
    }
    if(document.querySelector('.message--javascript.message')){
        const msg = document.querySelector('.message--javascript');
        msg.classList.remove('message');
        msg.innerText ='';
    }
    if(window.location.hash == '#msg'){
        addMsg(msg);
     }
 })

 const removeRadio = name => {
     document.querySelectorAll('[name='+ name +']')
     .forEach(r => {
         r.checked = false;
     })
 }

 if(document.querySelector('.procedure--chosen')){
     const procedureChosen = document.querySelector('.procedure--chosen');
     const backToProceduresBtn = document.querySelector('.back--to--procedures');
     const serviceBox = document.querySelector('.service--box');
     const callendarBox = document.querySelector('.callendar--box');
     const callendarHeader = callendarBox.querySelector('h4>b');
     const callendarBtnBox= document.querySelector('.callendar--btn--box');
     const masterActions = document.querySelector('.card--body');
    const masterInfoDOM = document.querySelector('.master--info');
    if(window.location.hash) {
        const procedureId = window.location.hash.replace('#','');
        const label = document.querySelector('label[for="' + procedureId + '"]');
        const masterNameText = document.querySelector('.card-title,text-danger').innerText
        masterActions.classList.add('d-none');
        serviceBox.classList.add('d-none');
        callendarBox.classList.remove('d-none');
        callendarHeader.innerText = label.innerText;
        let masterH2 = document.createElement('h2');
        masterH2.append(masterNameText);
        masterInfoDOM.append(masterH2);
        masterInfoDOM.style.alignItems = 'center';
        masterInfoDOM.style.gap = '50px';
        masterInfoDOM.firstElementChild.firstElementChild.classList.remove('col-md-5')
        masterInfoDOM.closest('.card').classList.remove('flex');
    } else {
        procedureChosen.addEventListener('click', () => {
            const procedureId = document.querySelector('input[name=procedure]:checked')?.value;
            const label = document.querySelector('label[for="' + procedureId + '"]');
            if(!procedureId){
                addMsg('You did not choose procedure. Please choose from the list.');
            } else{
                removeMsg();
                serviceBox.classList.add('d-none');
                callendarBox.classList.remove('d-none');
                callendarBtnBox.classList.remove('d-none');
                callendarBtnBox.classList.add('rating-form');
                callendarHeader.innerText = label.innerText;
            }
    });

    backToProceduresBtn.addEventListener('click', () => {
            serviceBox.classList.remove('d-none');
            callendarBox.classList.add('d-none');
            callendarBtnBox.classList.add('d-none');
            callendarBtnBox.classList.remove('rating-form');
            callendarHeader.innerText = '';
        })
    }
}
 if(document.querySelector('.order--appointments')){
    console.log( document.querySelector('.order--appointments'));
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
                console.log(res.data);
                if(res.data.message){
                    document.querySelector('tbody').innerHTML = '';
                    addMsg(res.data.message);
                }
                if(res.data.msgs){
                    addMsgs(res.data.msgs);
                }
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
    const thisDayEvents = (dateProp) => {
        const date = dateProp;
        const masterId = document.querySelector('[name="master_id"]').value;
        let procedureId;
        if(!window.location.hash){
            procedureId = document.querySelector('input[name="procedure"]:checked')?.value;
        }
        else {
            procedureId = window.location.hash.replace('#','');
            
        }
        axios.post(dayUrl, {date, masterId, procedureId})
        .then(res => {           
            document.querySelector('.day--appointments').innerHTML = res.data.html;
            if(window.location.hash){
                document.querySelector('.add--to--cart').innerText = 'Edit';
            }
            if(window.innerWidth < 992){
                document.querySelector('.callendar-day-menu').scrollIntoView({behavior: "smooth"});
            }
            addToCart();
        })
    }
    const setDayEvents =() => {
        document.querySelectorAll('.week--day')
         .forEach(b => {
            if(!b.classList.contains('no-hover')){
                b.addEventListener('click', () => {
                    thisDayEvents(b.dataset.timeData);
                })
            }
        })
    }
    const addToCart = () => {
        const addToCartBtn = document.querySelector('.add--to--cart');
        const masterId = document.querySelector('[name=master_id]').value;
        if(!addToCartBtn.dataset.registered){
            addToCartBtn.dataset.registered = true;
            addToCartBtn.addEventListener('click', () => {
                const appintmentRadioBtn = document.querySelector('input[name=free-time]:checked');
                const appointmenTime = appintmentRadioBtn.closest('tbody');
                const dateTime = document.querySelector('.appointment--date').innerText + ' ' + appointmenTime.querySelector('.appointment--starts').innerText;
                if(!window.location.hash){
                    const appointment = {
                        'procedureId': document.querySelector('input[name="procedure"]:checked')?.value,
                        'dateTime': dateTime,
                    }
                    axios.post(addToCartUrl, {masterId, appointment})
                    .then(res => {
                        const date = document.querySelector('.appointment--date').innerText;
                        thisDayEvents(date);
                        addMsg(res.data.message);
                        cartUpdate();
                    })
                }
                else {
                    let path = location.pathname;
                    const leRegex = /[\d]{4}[-][0-1][0-9][-][0-3][0-9][+][0-2][0-9][:][0-5][0-9]/;
                    const match = path.match(leRegex);
                    const previousDate = match[0];
                    console.log()
                    const appointment = {
                        'procedureId': window.location.hash.replace('#',''),
                        'dateTime': dateTime,
                    }
                    axios.put(updateToCartUrl, {masterId, previousDate, appointment})
                    .then(res => {
                        const redirectUrl = cartBladeUrl + '#msg';
                        window.location.href = redirectUrl;
                        // addMsg(res.data.message);
                        //  cartUpdate();
                    });
                }
                
            })
        }
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
                ratingNum.innerText = res.data.newRating;
                addMsg(res.data.message);
            })
        })
    })
   
 }