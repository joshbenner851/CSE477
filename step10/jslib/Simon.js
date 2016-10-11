/**
 * Created by joshbenner on 4/16/16.
 */
function Simon(sel) {
    // Get a reference to the form object
    this.form = $(sel);
    var that = this;

    this.state = "initial";
    this.sequence = [];
    this.sequence.push(Math.floor(Math.random() * 4));
    this.current = 0;


    console.log('Simon started');
    this.configureButton(0,"red");
    this.configureButton(1,"green");
    this.configureButton(2,"blue");
    this.configureButton(3,"yellow");

    this.play();


}

Simon.prototype.configureButton = function(ndx,color){
    var button = $(this.form.find("input").get(ndx));
    console.log(button);
    var that = this;

    button.click(function(event) {

        if(ndx != that.sequence[that.current]){
            document.getElementById("buzzer").play();
            that.state = "fail";
            that.sequence = [];
            that.sequence.push(Math.floor(Math.random() * 4));
            window.setTimeout(function() {
                that.play();
               // Do something
            }, 1000);
        }
        else{
            document.getElementById(color).currentTime = 0;
            document.getElementById(color).play();
            if(that.current == that.sequence.length - 1){
                console.log("got here");
                that.sequence.push(Math.floor(Math.random() * 4));
                window.setTimeout(function() {
                that.play();
               // Do something
            }, 1000);

            } else{
                that.current++;
            }
        }
        console.log(that.current);
        console.log("btn # pressed: " ,ndx);
        console.log(that.sequence);
    });

    button.mousedown(function(event){
        button.css("background-color",color);
    });

    button.mouseup(function (event) {
        button.css("background-color","lightgrey");
    });
}

Simon.prototype.playCurrent = function(){
    var that = this;

    if(this.current < this.sequence.length){
        //We have one to play
        var colors = ["red","green","blue","yellow"];
        //Play the sound
        document.getElementById(colors[this.sequence[this.current]]).play();
        //Need to pass in the button
        //console.log("button?: " ,$(this.form.find("input").get(this.current)));
        //console.log("this: ", this);
        var button = $(this.form.find("input").get(this.sequence[this.current]));
        var color = colors[this.sequence[this.current]];
        //Turn on the button
        this.buttonOn(button,color);
        this.current++;
        window.setTimeout(function() {
            that.playCurrent();
   // Do something
}, 1000);
    }
    else{
        this.current = 0;
        this.state = "enter";
    }
}

Simon.prototype.buttonOn = function(button,color){
    var that = this;
    //console.log("btn: " ,button);
    button.css("background-color",color);
    window.setTimeout(function() {

   // Do something
    $("input[type=button]").css("background-color" , "lightgrey");
}, 1000);

}

Simon.prototype.play = function(){
    var that = this;
    this.state = "play";
    this.current = 0;
    that.playCurrent();
}

