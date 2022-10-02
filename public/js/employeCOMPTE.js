var tab= new Array(3);
tab[0]="rgba(255, 0, 0, 0.6)";
tab[1]="rgba(0, 0, 255, 0.6)";
tab[2]="rgba(255, 255, 0, 0.6)";
const bubbleMaker = () =>{




const bubble = document.createElement("spane");
bubble.classList.add("bubble");
document.body.appendChild(bubble);
const size = Math.random()*200 + 100 +"px";
bubble.style.height = size;
bubble.style.width = size;

bubble.style.setProperty("--val",Math.random()*100 + "%");
var couleur="orange" ;
if(Math.random() <= 0.3 ){
    couleur= tab[0];
}else if(0.3>Math.random() <= 0.6){
    couleur= tab[1];
}else{
     couleur= tab[2];
}
bubble.style.setProperty("--color",couleur );

bubble.style.top = Math.random()*100 + 50 + "%";
bubble.style.left = Math.random()*100 +  "%";
const plusMinus = Math.random() > 0.5 ? 1 : -1;
bubble.style.setProperty("--left",Math.random()*100*plusMinus + "%");

}
setInterval(bubbleMaker,400);