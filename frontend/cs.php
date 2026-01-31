<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #wqe {
            font-size: 50px;
            font-style: italic;
            font-weight: 500;
            color: red;
        }

        #ttt {
            background-color: blue;
            background-repeat: no-repeat;
            background-size: contain;
            background-image: url("");
            background-position: center center;
        }

        .yyy {
            text-align: right;
            text-transform: capitalize;
            text-indent: 10px;
        }

        #table1 {
            border: 3px solid blue;
            border-collapse: collapse;
        }

        .tatd1 {
            border: 3px solid blue;
            vertical-align: top;
            padding: 30px;
        }

        #cs1+p {
            color: red;
        }

        #cs2~p {
            color: green;
        }

        #kkk p {
            color: blue;
        }

        #cs3~div {
            border: 3px solid gray;
            width: 500px;
            height: 200px;
        }

        #cs4>p {
            border: 3px solid gray;
            width: 50px;
            height: 20px;
        }

        .cv {
            float: right;
        }

        .cf {
            float: left;
        }

        #csbox {
            background-color: blue;
            width: 300px;
            margin: auto;
            height: 300px;
            box-shadow: 0 40px 20px aqua;
            clear: both;
            border-radius: 50px;
        }

        #csdh1 {
            overflow: hidden;
            float: left;
            margin: 10px auto auto 0px;
            animation: csdh 3s ease-in-out 0s infinite alternate;
            background-color: red;
            width: 100px;
            height: 100px;
        }

        #csdh1:hover {
            animation-play-state: running;
        }

        @keyframes csdh {
            0% {
                margin-left: 0px;
            }

            100% {
                margin-left: 600px;
            }
        }

        @media screen and (min-width:700px) {}
    </style>
</head>

<body>
    <script>

        document.write(kkk);
        console.log(kkk);
        alert("kkk");
        var kkk = 6;
        var ooo = "owuhjsad'adads'fdsfsfjsdj\
        efaijnfdasinjfsnj\
        asafaf";
        console.log(ooo);
        console.log(ooo.length);
        var a = "sdsaf";
        var b = 123;
        var pj = a.concat(b)
        console.log(pj);
    </script>
    <h1 align="center">123</h1>
    <h2 color="red" align="right">456</h2>
    <p style="color:red">123456</p>
    <hr>
    <p style="font-size:20px" align="right">bbbbb</p>
    <br>
    <hr color="green" width="400px" size="25px" align="left">
    <br />
    <img src="dz" alt="666">
    <br />
    <a href="#">123</a>
    <em>重点1</em><br>
    <i>斜体</i><br>
    <strong>重点2</strong><br>
    <b>粗体</b><br>
    <del>dsafsafds删除</del><br>
    <span>无意义</span><br>
    <ol type="i">
        <li>123</li>
        <li>666</li>
    </ol>
    <ul type="circle">
        <li>ssss</li>
        <li>6666</li>
        <li>666</li>
        <li>fgfg</li>
    </ul>
    <table border="5px">
        <tr>
            <td>666234</td>
            <td colspan="2">666</td>
        </tr>
        <tr>
            <td>666</td>
            <td>666</td>
        </tr>
        <tr>
            <td>666</td>
            <td>666</td>
            <td>666</td>
        </tr>
    </table>
    <form action="" method="get" name="666">
        <input type="text">
        <input type="password">
        <input type="submit">
    </form>
    <br />
    <p id="wqe">sfjsdfijsdijosdiofsd</p>
    <br />
    <div id="ttt">

    </div>
    <br />
    <p class="yyy">dd大声读书大赛怀旧服哈佛合计阿萨达发哈打撒好吧很大VS不海拔是大V很大深V胡打撒防护地税发护发</p>
    <br />
    <table id="table1">
        <tr class="tatr1">
            <td class="tatd1">SAS</td>
            <td class="tatd1">SAS</td>
            <td class="tatd1">SAS</td>
        </tr>
        <tr class="tatr1">
            <td class="tatd1">SAS</td>
            <td class="tatd1">SAS</td>
            <td class="tatd1">SAS</td>
        </tr>
        <tr class="tatr1">
            <td class="tatd1">SAS</td>
            <td class="tatd1">SAS</td>
            <td class="tatd1">SAS</td>
        </tr>
    </table>
    <br />
    <div>
        <p id="cs1">fsdehjieiujfef</p>
        <p>+为相邻下面兄弟选择器</p>
        <p>+为相邻下面的兄弟选择器</p>
    </div>
    <div>
        <p id="cs2">fsdehjieiujfef</p>
        <p>~为兄弟选择器</p>
        <p>~邻下面的兄弟选择器</p>
        <p>~邻下面的兄弟选择器</p>
    </div>
    <div id="kkk">
        <p id="cs3">&nbsp hhh</p>
        <p>~为兄弟选择器</p>
        <div>
            <p>~邻下面的兄弟选择器</p>
        </div>
        <p>~邻下面的兄弟选择器</p>
    </div>
    <div id="cs4">
        <p>cs4</p>
        <p>~为兄弟选择器</p>
        <div>
            <p>~邻下面的兄弟选择器</p>
        </div>
        <p>~邻下面的兄弟选择器</p>
    </div>
    <br />
    <div id="lll">
        <p class="cv">dd大声读书很大</p>
        <p class="cf">dd大声读书大赛怀旧服哈佛合计阿萨达发哈打撒好吧很大VS不海拔是大V很大深V胡打撒防护地税发护发</p>
    </div>
    <br />
    <div id="csbox">

    </div>
    <br />
    <div id="csdh1"></div>
</body>

</html>