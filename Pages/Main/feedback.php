<div id="promotion-list-carausel">
    <section class="pt-5 pb-5">
        <div class="container">
            <div style="text-align: end;">
                <a href="#" style="color: black; font-size: small;">Write your feedback here ✍️</a>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
    
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="row">

                                    <div class="col-md-4 mb-3">
                                        <div class="card feedback-card">
                                            <div class="feedback-wrapper">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <img id="avatar" alt="Avatar" height="50" class="avatar">
                                                    </div>
                                                    <div class="col p-0">
                                                        <p class="m-0"><b>Username</b></p>
                                                        <div style="font-size: small;">
                                                            <span class="fa fa-star checked"></span>
                                                            <span class="fa fa-star checked"></span>
                                                            <span class="fa fa-star checked"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text" style="font-size: small;">I think that this store is so good. It’s user friendly and I can have the products delivered to me within 24 hours. What a steal!</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="card feedback-card">
                                            <div class="feedback-wrapper">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <img id="avatar2" alt="Avatar" height="50" class="avatar">
                                                    </div>
                                                    <div class="col p-0">
                                                        <p class="m-0"><b>Username</b></p>
                                                        <div style="font-size: small;">
                                                            <span class="fa fa-star checked"></span>
                                                            <span class="fa fa-star checked"></span>
                                                            <span class="fa fa-star checked"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text" style="font-size: small;">I think that this store is so good. It’s user friendly and I can have the products delivered to me within 24 hours. What a steal!</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="card feedback-card">
                                            <div class="feedback-wrapper">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <img id="avatar3" alt="Avatar" height="50" class="avatar">
                                                    </div>
                                                    <div class="col p-0">
                                                        <p class="m-0"><b>Username</b></p>
                                                        <div style="font-size: small;">
                                                            <span class="fa fa-star checked"></span>
                                                            <span class="fa fa-star checked"></span>
                                                            <span class="fa fa-star checked"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text" style="font-size: small;">I think that this store is so good. It’s user friendly and I can have the products delivered to me within 24 hours. What a steal!</span></p>
                                            </div>
                                        </div>
                                    </div>
    
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="row">
    
                                    <div class="col-md-4 mb-3">
                                        <div class="card feedback-card">
                                            <div class="feedback-wrapper">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <img id="avatar4" alt="Avatar" height="50" class="avatar">
                                                    </div>
                                                    <div class="col p-0">
                                                        <p class="m-0"><b>Username</b></p>
                                                        <div style="font-size: small;">
                                                            <span class="fa fa-star checked"></span>
                                                            <span class="fa fa-star checked"></span>
                                                            <span class="fa fa-star checked"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text" style="font-size: small;">I think that this store is so good. It’s user friendly and I can have the products delivered to me within 24 hours. What a steal!</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function generateAvatar(
        text,
        foregroundColor = "white",
        backgroundColor = "black"
        ) {
        const canvas = document.createElement("canvas");
        const context = canvas.getContext("2d");

        canvas.width = 200;
        canvas.height = 200;

        // Draw background
        context.fillStyle = backgroundColor;
        context.fillRect(0, 0, canvas.width, canvas.height);

        // Draw text
        context.font = "bold 80px Poppins";
        context.fillStyle = foregroundColor;
        context.textAlign = "center";
        context.textBaseline = "middle";
        context.fillText(text.match(/(\b\S)?/g).join("").match(/(^\S|\S$)?/g).join("").toUpperCase(), canvas.width / 2, canvas.height / 2);

        return canvas.toDataURL("image/png");
    }

    const colorBgList = ["#B83B5E", "purple"];
    document.getElementById("avatar").src = generateAvatar(
        "Balqis Kinanti",
        "white",
        colorBgList[Math.floor(Math.random()*colorBgList.length)]
    );
    document.getElementById("avatar2").src = generateAvatar(
        "Balqis Kinanti",
        "white",
        colorBgList[Math.floor(Math.random()*colorBgList.length)]
    );
    document.getElementById("avatar3").src = generateAvatar(
        "Balqis Kinanti",
        "white",
        colorBgList[Math.floor(Math.random()*colorBgList.length)]
    );
    document.getElementById("avatar4").src = generateAvatar(
        "Balqis Kinanti",
        "white",
        colorBgList[Math.floor(Math.random()*colorBgList.length)]
    );
</script>