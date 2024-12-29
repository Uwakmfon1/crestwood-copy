@extends('layouts.user.index')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container-fluid">
            @include('partials.users.alert')
            <div id="savings-card-container" class="mt-5">
            </div>
        </div>
    </div>
<!-- End::app-content -->

@endsection

@section('scripts')

<script>

    let cardData = null;

    // Fetch data from the server before document ready
    $.ajax({
        url: `/fetch/plans/${window.location.pathname.split('/')[3]}`, // Adjust the URL as necessary
        method: 'GET',
        async: false,  // Wait for the request to complete before moving forward
        success: function (response) {
            cardData = response;  // Store the fetched data in cardData
        },
        error: function (xhr, status, error) {
            console.error('Error fetching plan data:', error);
        }
    });

    $(document).ready(function () {
        const selectedCard = cardData; // Find the card data based on the route ID

        if (selectedCard) {
            // Create the card content dynamically
            let cardHtml = `
                <div class="card mx-auto px-3 py-3" style="max-width:850px;">
                    <div class="">
                        <div class="my-4">
                            <div class="" id="back-arrow" style="position: absolute; top: 28px; left: 20px; cursor: pointer;">
                                <a href="/savings/create" ><i class="fe fe-x text-dark me-2"></i></a>
                            </div>
                            <h5 class="modal-title text-center fw-bold">${selectedCard.name}</h5>
                            <p class="modal-title text-center text-muted fs-12 mx-auto mt-2" style="max-width: 300px;">${selectedCard.description}</p>
                        </div>

                        <div class="progress-container mx-auto" style="background: rgba(0, 0, 0, 0.03); height: 6px; width: 100%; position: relative; top: 0; left: 0; max-width: 550px;">
                            <div class="bg-primary rounded" id="progress-bar-${selectedCard.modalId}" style="height: 100%; width: 0%; transition: width 0.3s;"></div>
                        </div>

                        <form id="savings-form" class="mx-auto" method="POST" action="{{ route('savings.store') }}" style="max-width: 550px;">
                            @csrf
                            <input type="hidden" name="plan_id" value=""> <!-- Hidden plan_id -->
                            <input type="hidden" name="answers" value=""> <!-- Hidden answers JSON -->
                            <div id="question-container-${selectedCard.modalId}">
                `;

            // Create an array of screen names for navigation
            const screens = selectedCard.questions.map((_, index) => `screen-${index}`);
            screens.push('summary-screen'); // Add the summary screen as the last screen
            let currentIndex = 0; // Start with the first question

            // Store selected answers
            let selectedAnswers = {};

            // Create a question container for each question
            selectedCard.questions.forEach((q, index) => {
                const questionId = `question-${index}`; // Generate a unique ID based on index

                cardHtml += `
                    <div class="${screens[index]} question-card" style="display: ${index === 0 ? 'block' : 'none'};">
                        <div class="my-2">
                            <label class="text-left fs-13 fw-bold my-3">${q.question}</label>
                            <div class="error-message fw-bold fs-12 mb-3" id="error-${questionId}" style="display: none; color: red; text-align: center;">Please select an answer.</div>
                            <div class="form-check-group"> 
                                ${q.answers.map((answer, aIndex) => `
                                    <div class="form-check mb-2" style="border: 1px solid rgba(0, 0, 0, 0.1); padding: 20px 0px; border-radius: 15px; cursor: pointer;">
                                        <input class="form-check-input mx-3" type="radio" name="answer-${questionId}" value="${answer}" id="radio-${questionId}-${aIndex}">
                                        <label class="form-check-label mx-3" for="radio-${questionId}-${aIndex}">
                                            ${answer}
                                        </label>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    </div>
                `;
            });

            // Add the navigation buttons
            cardHtml += `
                        </div>
                        <div class="d-flex justify-content-between mx-auto my-4" style="max-width: 550px;">
                            <button type="button" class="btn btn-dark-transparent border-0" id="prevButton-${selectedCard.modalId}" disabled>
                                <i class="fe fe-arrow-left"></i> Previous
                            </button>
                            <button type="button" class="btn btn-primary-transparent px-4" id="nextButton-${selectedCard.modalId}">
                                Next <i class="fe fe-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        `;

            // Append the dynamically generated HTML to the savings card container
            $('#savings-card-container').html(cardHtml);

            // Show the current question based on index
            function showQuestion(index) {
                // Hide all screens first
                $('.question-card').hide();

                if (index === screens.length - 1) {
                    // If the current index is the last screen (summary screen), display summary
                    showSummaryScreen();
                } else {
                    // Show the current screen
                    $(`.${screens[index]}`).show();
                }

                // Update the progress bar width based on the current screen index
                const progressBar = $(`#progress-bar-${selectedCard.modalId}`);
                const progressPercentage = (index / (screens.length - 1)) * 100;
                progressBar.css('width', `${progressPercentage}%`);

                // Disable Previous button on the first screen or summary screen
                $(`#prevButton-${selectedCard.modalId}`).prop('disabled', index === 0 || index === screens.length - 1);

                // Change the "Next" button to "Submit" on the summary screen
                if (index === screens.length - 1) {
                    $(`#nextButton-${selectedCard.modalId}`).text('Submit').off('click').on('click', function () {
                        submitForm(); // Submit the form when clicking submit
                    });
                } else {
                    // Set "Next" button back to "Next" on non-last screens
                    $(`#nextButton-${selectedCard.modalId}`).text('Next').off('click').on('click', function () {
                        validateAndProceed(); // Validate and proceed to the next question
                    });
                }

                // Update the button text based on index
                $(`#nextButton-${selectedCard.modalId}`).html(
                    index === screens.length - 1 
                        ? 'Submit <i class="fe fe-check"></i>' 
                        : 'Next <i class="fe fe-arrow-right"></i>'
                );
            }

            // Display the first question on load
            showQuestion(currentIndex);

            // Validate the current screen before moving to the next
            function validateAndProceed() {
                const currentQuestion = selectedCard.questions[currentIndex];
                const questionId = `question-${currentIndex}`;
                const selectedAnswer = $(`input[name="answer-${questionId}"]:checked`).val();

                if (!selectedAnswer) {
                    // Show validation error
                    $(`#error-${questionId}`).show();
                } else {
                    // Hide error message if an answer is selected
                    $(`#error-${questionId}`).hide();
                    selectedAnswers[questionId] = {
                        question_id: $(`input[name="answer-${questionId}"]:checked`).data('question-id'),
                        answer_id: selectedAnswer
                    };

                    if (currentIndex < screens.length - 1) {
                        currentIndex++;
                        showQuestion(currentIndex);
                    } else {
                        // If it's the last screen, trigger the submission
                        submitForm();
                    }
                }
            }

            // Show summary screen
            function showSummaryScreen() {
                let summaryHtml = `
                    <div class="question-card">
                        <h5 class="text-center fw-bold my-4">Summary</h5>
                        <div class="summary-container mx-auto" style="max-width: 550px;">
                            ${selectedCard.questions.map((q, index) => `
                                <div class="summary-item my-3">
                                    <p class="text-muted fs-12">${q.question}</p>
                                    <h6 class="fw-bold fs-13">${selectedAnswers[`question-${index}`]?.answer_id || 'No answer selected'}</h6>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;

                // Replace the question container content with the summary
                $(`#question-container-${selectedCard.modalId}`).html(summaryHtml);
            }

            // Previous button functionality
            $(`#prevButton-${selectedCard.modalId}`).click(function () {
                if (currentIndex > 0) {
                    currentIndex--;
                    showQuestion(currentIndex);
                }
            });

            // Submit the form
            function submitForm() {
                // Set plan_id from selectedCard (you might have a way to set it in your code)
                $('input[name="plan_id"]').val(selectedCard.id);

                // Convert selected answers to the required format
                const formattedAnswers = Object.values(selectedAnswers);
                $('input[name="answers"]').val(JSON.stringify(selectedAnswers));

                // Submit the form
                $('#savings-form').submit();
            }

            // Make the entire form-check div clickable
            $(document).on('click', '.form-check', function () {
                const radioInput = $(this).find('input[type="radio"]');
                radioInput.prop('checked', true); // Select the radio button
                radioInput.trigger('change'); // Trigger change event in case there is a listener
            });
        }
    });
</script>

@endsection