@extends('layouts.user.index')

@section('content')

<style>
    select {
        appearance: auto !important;
        -webkit-appearance: auto;
        -moz-appearance: auto;
    }
    select:focus {
        appearance: none;
    }
    li {
        padding: 10px;
    }
</style>

<!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container-fluid">
            @include('partials.users.alert')
            <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h1 class="page-title fw-medium fs-18 mb-2">Savings</h1>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);">
                            Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Savings</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Plans</li>
                    </ol>
                </div>
            </div>

        </div>

        <div class="row mx-2 no-gutters" id="cardContainer">
             <!-- :::Content goes here --> 
        </div>
    </div>

    <div class="modal fade" id="iraModal" tabindex="-1" role="dialog" aria-labelledby="iraModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 700px;">
            <div class="modal-content">
                <form method="POST" action="{{ route('withdraw') }}" id="depositForm">
                    @csrf
                    <div class="my-4">
                        <h5 class="modal-title text-center fw-bold" id="nairaDepositModalLabel">Select Retirement Accounts</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row mx-auto" id="depoSelect" style="max-width: 600px;">
                        <div class="row mx-auto my-auto" id="depoSelect" style="max-width: 600px;">
                            <div class="col-md-6 col-sm-12">
                                <a href="/start/savings/6">
                                    <div class="card text-center selectdepo mx-auto pt-5" id="selectCrypto">
                                        <div class="card-body align-items-center rounded">
                                            <span class="avatar avatar-md me-2 mb-3">
                                                <img class="p-1" src="https://cdn-icons-png.flaticon.com/512/1389/1389960.png" alt="">
                                            </span>
                                            <h5 class="fw-bold fs-14 mt-2 mx-2"> 
                                                Roth IRA
                                            </h5>
                                            <p class="text-center text-muted fs-10" style="margin-top: -5px;">Enjoy tax-free growth and withdrawals in retirement with post-tax contributions.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <a href="/start/savings/7">
                                    <div class="card text-center selectdepo mx-auto pt-5" id="selectBank">
                                        <div class="card-body align-items-center rounded">
                                            <span class="avatar avatar-md me-2 mb-3">
                                                <img class="p-1" src="https://cdn-icons-png.flaticon.com/512/2845/2845642.png" alt="">
                                            </span>
                                            <h5 class="fw-bold fs-14 mt-2 mx-2"> 
                                                SEP IRA
                                            </h5>
                                            <p class="text-center text-muted fs-10" style="margin-top: -5px;">Save for retirement with high contribution limits designed for self-employed individuals.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 col-sm-12 mx-auto">
                                <a href="/start/savings/8">
                                    <div class="card text-center selectdepo mx-auto pt-5" id="selectBank">
                                        <div class="card-body align-items-center rounded">
                                            <span class="avatar avatar-md me-2 mb-3">
                                                <img class="p-1" src="https://cdn-icons-png.flaticon.com/512/2746/2746077.png" alt="">
                                            </span>
                                            <h5 class="fw-bold fs-14 mt-2 mx-2"> 
                                                Traditional IRA
                                            </h5>
                                            <p class="text-center text-muted fs-10" style="margin-top: -5px;">Benefit from tax-deferred savings to build your retirement fund.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- End::app-content -->

@endsection

@section('scripts')

<script>
$(document).ready(function() {
    // Fetch data from the server instead of using hardcoded data
    $.ajax({
        url: '/fetch/plans', // Endpoint to fetch data
        type: 'GET',
        dataType: 'json',
        success: function(cardData) {
            // cardData should be an array of objects similar to the hardcoded example
            cardData.data.forEach((card, index) => {
                const startSavingsButton = card.id === 6 
                ? `<a href="#" class="btn btn-primary-transparent px-4 fs-12 view-more-link" 
                        data-toggle="modal" 
                        data-target="#iraModal" 
                        data-info="Data....">
                    Start Savings <i class="fe fe-plus me-2"></i>
                   </a>
                   `
                : `<a href="/start/savings/${card.id}" class="btn btn-primary-transparent px-4 fs-12" 
                        data-index="${index}" 
                        data-toggle="modal" 
                        data-target="#${card.modalId}">
                    Start Savings <i class="fe fe-plus me-2"></i>
                   </a>`;

                const cardHtml = 
                    `<div class="col-md-4 col-sm-12">
                        <div class="card py-4">
                            <div class="px-auto text-center py-1">
                                <span class="avatar avatar-xl bg-transparent me-2 mb-3">
                                    <img class="p-1" src="${card.img}" alt="">
                                </span>
                                <h5 class="fw-medium fs-14 mt-2 mx-2">${card.name}</h5>
                                <p class="modal-title text-center text-muted fs-12 mx-auto mt-2" id="${card.modalId}Label" style="max-width: 300px;">
                                    ${card.description} 
                                    <a href="#" 
                                        class="fw-bold text-primary fs-11 view-more-link" 
                                        data-toggle="modal" 
                                        data-target="#${card.modalId}" 
                                        data-info="${card.info}">
                                        view more
                                    </a>
                                </p>
                            </div>
                            <div class="text-center px-auto py-3">
                                ${startSavingsButton}
                            </div>
                        </div>
                    </div>`;
                
                // Append card to the container
                $('#cardContainer').append(cardHtml);

                // Create modal dynamically for each card
                const modalHtml = `
                    <div class="modal fade" id="${card.modalId}" tabindex="-1" role="dialog" aria-labelledby="${card.modalId}Label" aria-hidden="true">
                        <div class="modal-dialog" role="document" style="max-width: 700px;">
                            <div class="modal-content">
                                <div class="row d-flex justify-content-center mx-auto">
                                    <div class="my-4">
                                        <h5 class="modal-title text-center fw-bold" id="${card.modalId}Label">${card.name}</h5>
                                        <p class="modal-title text-center text-muted fs-12 mx-auto mt-2" id="${card.modalId}Label" style="max-width: 300px;">${card.description}</p>
                                    </div>
                                    <div class="fw-bold fs-18" id="back-arrow" style="position: absolute; top: 22px; right: -20px; cursor: pointer;" data-bs-dismiss="modal">
                                        <i class="fe fe-x me-2"></i>
                                    </div>
                                    <div class="progress-container" style="background: rgba(0, 0, 0, 0.03); height: 6px; width: 100%; position: relative; top: 0; left: 0; max-width: 550px;">
                                        <div class="bg-primary rounded" id="progress-bar-${card.modalId}" style="height: 100%; width: 0%; transition: width 0.3s;"></div>
                                    </div>
                                    <div id="question-container-${card.modalId}" class="mx-auto mb-4" style="max-width: 550px;">
                                        <p id="info-content-${card.modalId}" class="text-left mt-4"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                
                // Append modal to the body
                $('body').append(modalHtml);
            });

            // Handle "view more" click to populate the modal with `card.info`
            $(document).on('click', '.view-more-link', function (e) {
                e.preventDefault();
                const modalId = $(this).data('target').replace('#', '');
                const info = $(this).data('info');
                $(`#info-content-${modalId}`).html(info);
                $(`#${modalId}`).modal('show');
            });

            // Attach the click event for buttons after the cards are generated
            $('.open-modal-btn').click(function() {
                const cardIndex = $(this).data('index');
                const selectedCard = cardData[cardIndex];
                const modalId = selectedCard.modalId;
                let currentQuestionIndex = 0;
                const totalQuestions = selectedCard.questions.length;

                // Function to update the progress bar
                function updateProgressBar() {
                    const progressPercentage = ((currentQuestionIndex + 1) / totalQuestions) * 100;
                    $(`#progress-bar-${modalId}`).css('width', `${progressPercentage}%`);
                }

                // Function to update the question screen
                function updateQuestion() {
                    const questionContainer = $(`#question-container-${modalId}`);
                    const questionData = selectedCard.questions[currentQuestionIndex];
                    
                    let answersHtml = '';
                    questionData.answers.forEach((answer) => {
                        answersHtml += `<div class="form-check">
                                            <input class="form-check-input" type="radio" name="answer${currentQuestionIndex}" value="${answer}">
                                            <label class="form-check-label">${answer}</label>
                                        </div>`;
                    });

                    const questionHtml = `<div>
                                            <h6>${questionData.question}</h6>
                                            ${answersHtml}
                                          </div>`;

                    questionContainer.html(questionHtml);
                    updateProgressBar();
                }

                // Initialize the first question
                updateQuestion();

                // Next and Previous button handlers
                $(`#nextButton-${modalId}`).click(function() {
                    if (currentQuestionIndex < totalQuestions - 1) {
                        currentQuestionIndex++;
                        updateQuestion();
                    }
                });

                $(`#prevButton-${modalId}`).click(function() {
                    if (currentQuestionIndex > 0) {
                        currentQuestionIndex--;
                        updateQuestion();
                    }
                });
            });
        },
        error: function(error) {
            console.error('Error fetching data:', error);
        }
    });
});



</script>

@endsection