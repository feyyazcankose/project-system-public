durum=document.getElementById('durum');
submit=document.getElementById('submit');
checkbox=document.getElementsByClassName('checkbox');


  function kontorol(checkbox)
  {
    tumu=document.getElementById('tumu');
    sayac=0;
    for (var i = 0; i <checkbox.length; i++) {
      if(checkbox[i].checked)
        sayac++;
    }
    if(sayac ==checkbox.length)
    {
      tumu.checked = true;
      return 1;
    }
    else if(sayac>0)
    {
      tumu.checked = false;
      return 1;
    }
    return 0;

  };

if(durum.selectedIndex!=0 && kontorol(checkbox))
    submit.disabled=false;

function disab(){
  durum=document.getElementById('durum');
  submit=document.getElementById('submit');
 checkbox=document.getElementsByClassName('checkbox');
  eylem=document.querySelector('.eylem');
  if(kontorol(checkbox)){
    eylem.style.display="block";
  }
  else
  {
    eylem.style.display="none";
  }

  if(durum.selectedIndex!=0 && kontorol(checkbox))
  {
    submit.disabled=false;
    submit.style.display="inline-block";
  }
  else
  {
    submit.style.display="none";
    submit.disabled=true;
  }
};

function tumuCheked()
{
 checkbox=document.getElementsByClassName('checkbox');
  tumu=document.getElementById('tumu');
  eylem=document.querySelector('.eylem');

  if(tumu.checked){
    for (var i = 0; i <checkbox.length; i++) {
     checkbox[i].checked=true;
  eylem.style.display="block";

    }
  }
  else{
    for (var i = 0; i <checkbox.length; i++) {
     checkbox[i].checked=false;
      eylem.style.display="none";
      tumu.checked=false;

    }
  }
};
