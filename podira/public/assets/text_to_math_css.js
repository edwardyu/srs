    var Macro = function (str) {
        this.str = str;
        this.arr = str.split(" ");
        for(i = 0; i < this.arr.length; i++){
            a = [this.arr[i],0];
            this.arr[i] = a;
        }
    };

    function markflags(arr,flags){
        for(i = 0; i < arr.length; i++){
            for(j = 0; j < flags.length; j++){
                if(arr[i][1] == 0 && arr[i][0].toUpperCase() == flags[j].toUpperCase()){
                    arr[i][1] = 1; // making it a flag.
                }
            }
        }
        return arr;
    }

    var Section = function (type,content) {
        this.type = type;
        this.content = content;
    };

    function getSections(arr, html, alias){  // code to transform sections into blocks;
        arr_of_sections = [];
        var sections_done = [];
        for(i = 0; i < arr.length; i++){
            if(arr[i][1] == 1) { // checking for flag
                var code = "";
                for(j = i + 1; j < arr.length; j++){
                    if(arr[j][1] == 1){
                        break;
                    }
                    var code = code + " " + arr[j][0];
                }
                arr_of_sections.push(new Section(arr[i][0],code));
            }
        }
        arr_of_sections.forEach(function(entry){
            for(i = 0; i < alias.length; i++){
                if(alias[i][0].toUpperCase() == entry.type.toUpperCase()){
                    type = alias[i][1];
                    break;
                }
            }

            if(sections_done.indexOf(type) == -1 && type != false){
              html.push("<div " + type + ">");
              html.push(parse(entry.content, false)); //recursive loop to parse
              html.push("</div>");
              sections_done.push(type);
            }

        });
        return html;
    }

    function writeHTML(name,arr, alias){
        html = [];
        // opening tag
        html.push("<div " + name + ">");
        // compilation code
        html = getSections(arr,html,alias);
        //closing tag
        html.push("</div>");
        html = html.join("\n");
        return html;
    }


    function Term(str) {
        Macro.call(this, str);
        this.html = "<div term>" + str + "</div>";
    }

    function Root(str) {
        Macro.call(this, str);
        this.flags = ["of", "of*", "ofthedegree", "andthen"];
        this.alias = [["of","of"],["of*","of"],["ofthedegree","degree"],["andthen",false]];
        this.arr = markflags(this.arr, this.flags);
        this.html = writeHTML("root",this.arr, this.alias);
        addHTML = parse(str.substring(str.indexOf("andthen")+7,str.length), true);
        if(str.indexOf("andthen") > 0){
          this.html = this.html + addHTML;
        }
    }

    function Fraction(str) {
        Macro.call(this, str);
        this.flags = ["of", "of*", "over", "allover", "dividedby"];
        this.alias = [["of","top"],["of*","top"],["over","bottom"],["allover","bottom"],
        ["dividedby","bottom"]];
        this.arr = markflags(this.arr, this.flags);
        this.html = writeHTML("fraction",this.arr, this.alias);
    }

    function Derivative(str) {
        substr = str.substring(str.indexOf("derivative"), str.indexOf("derivative") + 31);
        substr2 = str.substring(str.indexOf("derivative"), str.indexOf("derivative") + 15);

        if(substr.indexOf("withrespectto") + substr.indexOf("inrespectto") + substr2.indexOf("over") == -3){
          str = str.replace("of","of*");
          str = str.replace("derivative","derivative of x withrespectto y");
        }
        Macro.call(this, str);
        this.flags = ["of", "withrespectto", "inrespectto", "over","of*"];
        this.alias = [["of","top"],["withrespectto","bottom"],["inrespectto","bottom"],
        ["over","bottom"],["of*",false]];
        this.arr = markflags(this.arr, this.flags);
        this.html = writeHTML("derivative",this.arr, this.alias);
        addHTML = parse(str.substring(str.indexOf("of*")+3,str.length), true);
        if(str.indexOf("of*") > 0){
          this.html = this.html + addHTML;
        }
    }

    function Partial_Derivative(str){
        Derivative.call(this,str);
        this.html = this.html.replace("div derivative", "div partial derivative");
    }

    function Limit(str) {
        Macro.call(this, str);
        this.flags = ["of", "goingto", "headingto", "approaching", "of*"];
        this.alias = [["of","variable"],["goingto","goingto"],["headingto","goingto"],
        ["approaching","goingto"],["of*",false]];
        this.arr = markflags(this.arr, this.flags);
        this.html = writeHTML("limit",this.arr, this.alias);
        addHTML = parse(str.substring(str.indexOf("of*")+3,str.length), true);
        if(str.indexOf("of*") > 0){
          this.html = this.html + addHTML;
        }
    }

    function Product(str) {
        Macro.call(this, str);
        this.flags = ["of", "from", "to"];
        this.alias = [["of","of"],["from","lowerbound"],["to","upperbound"]];
        this.arr = markflags(this.arr, this.flags);
        this.html = writeHTML("Product",this.arr, this.alias);
    }

    function Summation(str) {
        Macro.call(this, str);
        this.flags = ["of", "from", "to"];
        this.alias = [["of","of"],["from","lowerbound"],["to","upperbound"]];
        this.arr = markflags(this.arr, this.flags);
        this.html = writeHTML("Summation",this.arr, this.alias);
    }

    function Integral(str) {
        Macro.call(this, str);
        this.flags = ["from", "to", "of*", "of"];
        this.alias = [["of",false],["of*",false],["from","lowerbound"],["to","upperbound"]];
        this.arr = markflags(this.arr, this.flags);
        this.html = writeHTML("Integral",this.arr, this.alias);
        addHTML = parse(str.substring(str.indexOf("of")+2,str.length), true);
        if(str.indexOf("of") > 0){
          this.html = this.html + addHTML;
        }
    }

    function Double_Integral(str){
        Integral.call(this,str);
        this.html = this.html.replace("div Integral", "div DoubleIntegral");
    }

    function Triple_Integral(str){
        Integral.call(this,str);
        this.html = this.html.replace("div Integral", "div TripleIntegral");
    }

    Integral.prototype.constructor = Integral;

    function prime(str){
        //TAGS
        sep = [[" to the power of ","sup"],[" squared","sup",2],[" cubed","sup",3]];
        for(i = 0; i < sep.length; i++){
            if(str.indexOf(sep[i][0]) != -1){
                index = str.indexOf(sep[i][0]);
                nextspace = str.indexOf(" ",index+sep[i][0].length);
                if(nextspace == -1){
                    nextspace = str.length;
                }
                val = str.substring(index+sep[i][0].length, nextspace);
                preindex = str.substring(0,index);
                if(nextspace != -1){
                    postindex = str.substring(nextspace, str.length);
                } else {
                    postindex = "";
                }
                openingtag = "<" + sep[i][1] + ">";
                if(sep[i][2]){
                    val = sep[i][2];
                }
                closingtag = "</" + sep[i][1] + ">";
                str = preindex + openingtag + val + closingtag + postindex;
            }
        }
        //HR REPLACEMENTS
        sep = [["infiniti","infty"],["infinity","infty"], ["*","times"], ["pi ","pi"]];
        for(i = 0; i < sep.length; i++){
          p = 0;
          while(str.indexOf(sep[i][0],p) != -1){

              str = str.replace(sep[i][0],"<hr " + sep[i][1] + ">");
              p++;
          }
        }

        //TERM REPLACEMENTS
        sep = [["going to","goingto"],["heading to","headingto"],
        ["with respect to","withrespectto"], ["in respect to","inrespectto"],
        ["all over","allover"], ["divided by","dividedby"],
        ["square root","root"], ["cube root","root of the degree 3"], ["of the degree","ofthedegree"],
        ["and then","andthen"]
        ];
        for(i = 0; i < sep.length; i++){
          if(str.indexOf(sep[i][0]) != -1){
              str = str.replace(sep[i][0],sep[i][1]);
          }
        }
        //explode string and mark repeated phrases
        all = str.split(" ");
        prop = ["of"];
        found = [];
        for(i = 0; i < all.length; i++){
          if(prop.indexOf(all[i]) != -1 && found.indexOf(all[i]) != -1){
            all[i] = all[i] + "*";
          } else if (prop.indexOf(all[i]) != -1){
            found.push(all[i]);
          }
        }
        str = all.join(" ");
        return str;
    }

    function parse(input,raw){
        var t = Math.floor(Date.now());

        i = input.toUpperCase();
        obj = false;
        var ind = 0;
        macros = ["TRIPLE INTEGRAL","DOUBLE INTEGRAL","INTEGRAL",
        "PRODUCT","SUMMATION","PARTIAL DERIVATIVE","DERIVATIVE",
        "LIMIT","FRACTION","ROOT"];

        minimum = i.length;

        var chosen = "";

        for(j = 0; j < macros.length; j++){
          if(i.indexOf(macros[j]) != -1 && minimum > i.indexOf(macros[j])){
              chosen = macros[j];
              minimum = i.indexOf(macros[j]);
          }
        }


        if(chosen == "TRIPLE INTEGRAL"){
            ind = i.indexOf("TRIPLE INTEGRAL");
            obj = new Triple_Integral(input);
        } else if(chosen == "DOUBLE INTEGRAL"){
            ind = i.indexOf("DOUBLE INTEGRAL");
            obj = new Double_Integral(input);
        } else if(chosen == "INTEGRAL"){
            ind = i.indexOf("INTEGRAL");
            obj = new Integral(input);
        } else if(chosen == "PRODUCT"){
            ind = i.indexOf("PRODUCT");
            obj = new Product(input);
        } else if(chosen == "SUMMATION"){
            ind = i.indexOf("SUMMATION");
            obj = new Summation(input);
        } else if(chosen == "PARTIAL DERIVATIVE"){
            ind = i.indexOf("PARTIAL DERIVATIVE");
            obj = new Partial_Derivative(input);
        } else if(chosen == "DERIVATIVE"){
            ind = i.indexOf("DERIVATIVE");
            obj = new Derivative(input);
        } else if(chosen == "LIMIT"){
            ind = i.indexOf("LIMIT");
            obj = new Limit(input);
        } else if(chosen == "FRACTION"){
            ind = i.indexOf("FRACTION");
            obj = new Fraction(input);
        } else if(chosen == "ROOT"){
            ind = i.indexOf("ROOT");
            obj = new Root(input);
        } else {
          if(raw != false){
            obj = new Term(input);
          }
        }

        var k = Math.floor(Date.now());

        if(obj !== false){
            prepend = new Term(input.substring(0,ind));
            return prepend.html + obj.html;
        } else {
            return input;
        }
    }

    function countInstances(string, word) {
       var substrings = string.split(word);
       return substrings.length - 1;
    }

    function post(str){
      //check for fractions and parse.
      while(str.indexOf("over") != -1){
        index = str.indexOf("over");

        parencount = 0;
        nextspace = -1;
        i = index + 5;


        nextspace = str.indexOf(" ", index+5);
        lastspace = str.lastIndexOf(" ", index - 2);
        lastbrace = str.lastIndexOf(">", index - 2);

        if(lastspace < lastbrace){
          lastspace = lastbrace;
        }

        addHTML = "</div><div fraction>" + "<div top>";
        addHTML = addHTML + str.substring(lastspace+1,index);
        addHTML = addHTML + "</div><div bottom>";
        addHTML = addHTML + str.substring(index + 5, nextspace);
        addHTML = addHTML + "</div></div><div term>";

        str = str.substring(0,lastspace+1) + addHTML + str.substring(nextspace+1, str.length);
      }

      //remove unnecessary describers
      remove  = [" the "," an "," there "," is "];
      for(i = 0; i < remove.length; i++){
        while(str.indexOf(remove[i]) != -1){
          str = str.replace(remove[i]," ");
        }
      }

      remove  = [">the ",">an ",">there ",">is "];
      for(i = 0; i < remove.length; i++){
        while(str.indexOf(remove[i]) != -1){
          str = str.replace(remove[i],">");
        }
      }

      return str;
    }

    function convert(str){
      str = prime(str);
      str = parse(str);
      str = post(str);
      return str;
    }

    var mathex = function(str){
      this.str = str;
      this.html = convert(str);
    }
