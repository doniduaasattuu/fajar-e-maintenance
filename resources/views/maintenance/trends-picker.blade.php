<!DOCTYPE html>
<html lang="en">

@include("utility.head")

<body>

    @include("utility.navbar")

    <div class="container py-5">
        <form id="trends-picker" method="get">

            <input type="date" name="start_date" id="start_date">
            <input type="date" name="end_date" id="end_date">

            <label for="emo_input">EMO</label>
            <input list="emo_datalist" id="emo_input">
            <datalist id="emo_datalist">
            </datalist>
        </form>
    </div>

    <script>
        const emo_datalist = document.getElementById("emo_datalist");
        const emo_input = document.getElementById("emo_input");
        const ajax = new XMLHttpRequest();

        // let emo_option = document.createElement("option");
        // emo_option.value = "Emo Option";
        // emo_option.textContent = "Emo Option Value";
        // emo_datalist.appendChild(emo_option);

        // GET EMO LIST IN DATA RECORD
        ajax.open("GET", "/emo-datalist")
        ajax.onload = () => {
            if (ajax.readyState == 4) {
                // console.log(JSON.parse(ajax.response).length); // 3
                // console.log(JSON.parse(ajax.response)[0].emo); // EMO000426
                let emo_datalist_length = JSON.parse(ajax.response).length;
                for (let i = 0; i < emo_datalist_length; i++) {
                    emo_value = JSON.parse(ajax.response)[i].emo
                    let emo_option = document.createElement("option");
                    emo_option.value = emo_value;
                    emo_option.textContent = emo_value;
                    emo_datalist.appendChild(emo_option);
                }
            }
        }
        ajax.send();

        let trends_picker = document.getElementById("trends-picker");
        trends_picker.onchange = () => {
            console.info(trends_picker);
            trends_picker.setAttribute("action", "/trends/" + emo_input.value);
        }
    </script>
</body>

</html>