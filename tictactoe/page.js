function TicTacToe(id,value="X")
{
    this.board = [['', '', ''], ['', '', ''], ['', '', '']];
    //place tile
    //check winner
    //switch who's move
    this.currentMove = value; //default
    this.winner = "";
    this.numOfMoves = 1;
    this.makeMove = function(r,c){
        if(this.winner == ""){
           this.board[r][c] = this.currentMove;
           this.checkWinner();
           if(this.winner == ""){
                    if(this.currentMove == "X"){
                        this.currentMove = "O";
                     }
                    else{
                        this.currentMove = "X";
                    }
           }
           this.present();
        }
        this.numOfMoves++;
    }

    this.checkWinner = function()
    {
        for(var r=0;r<this.board.length;r++)
        {
            if(this.board[r][0] == this.board[r][1] && this.board[r][0]==this.board[r][2] && this.board[r][0] == this.currentMove){
                this.winner = this.board[r][0];
            }
            else if(this.board[0][r] == this.board[1][r] && this.board[1][r]==this.board[2][r] && this.board[1][r] == this.currentMove){
                this.winner = this.board[0][r];
            }
            else if(this.board[0][0] == this.board[1][1] && this.board[1][1]==this.board[2][2] && this.board[1][1] == this.currentMove){
                this.winner = this.board[0][0];
            }
            else if(this.board[0][2] == this.board[1][1] && this.board[1][1]==this.board[2][0] && this.board[2][0] == this.currentMove){
                this.winner = this.board[0][2];
            }
        }
    }

    this.div = document.getElementById(id);
    this.present = function(){
        var html = "<table>";
        for(var i=0;i<this.board.length;i++)
        {
            html += "<tr>";
            for(var x=0;x<this.board[i].length;x++)
            {
                if(this.board[i][x] == ""){
                    html += "<td onclick='ttt.makeMove(" + i + ","
                    + x + ");'>&nbsp;</td>";
                }
                else{
                    html += "<td>" + this.board[i][x] + "</td>";
                }
            }
            html += "</tr>";
        }
        html += "</table>";
        if(this.winner !== ""){
            html += "<p class='text-center winner'>" + this.winner + " Wins!</p>";
            html += '<p class="text-center restart"><a  href="">New Game</a></p>';
        }
        else if(this.numOfMoves == 9){
            html += "<p class='text-center winner'> It's a scratch!</p>";
            html += '<p class="text-center restart"><a  href="">New Game</a></p>';
        }

        this.div.innerHTML = html;
    };

   this.present();
}