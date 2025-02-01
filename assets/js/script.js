$(document).ready(function () {
    let currentStep = 1;
    const totalSteps = 4;

    // Template selection
    $('.template-card').click(function () {
        $('.template-card').removeClass('selected');
        $(this).addClass('selected');
    });

    // Navigation between sections
    $('.next-section').click(function () {
        if (currentStep < totalSteps) {
            $('.form-section').removeClass('active');
            $(`.form-section[data-step="${currentStep + 1}"]`).addClass('active');
            currentStep++;
            updateNavigation();
        }
    });

    $('.prev-section').click(function () {
        if (currentStep > 1) {
            $('.form-section').removeClass('active');
            $(`.form-section[data-step="${currentStep - 1}"]`).addClass('active');
            currentStep--;
            updateNavigation();
        }
    });

    function updateNavigation() {
        $('.progress-bar').css('width', `${(currentStep / totalSteps) * 100}%`);
        $('.step-indicator').text(`Step ${currentStep} of ${totalSteps}`);
        $('.prev-section').prop('disabled', currentStep === 1);
        $('.next-section').prop('disabled', currentStep === totalSteps);
    }

    // Add education entry
    $('#addEducation').click(function () {
        const educationEntry = $('.education-entry').first().clone();
        educationEntry.find('input').val('');
        $('#educationContainer').append(educationEntry);
    });

    // Add experience entry
    $('#addExperience').click(function () {
        const experienceEntry = $('.experience-entry').first().clone();
        experienceEntry.find('input, textarea').val('');
        $('#experienceContainer').append(experienceEntry);
    });

    // Generate Resume
    $('#generateResume').click(function () {
        $generateResumeValue = $('#generateResume').val();
        // console.log($generateResumeValue);
        // exit();
        const selectedTemplate = $('.template-card.selected').data('template');
        if (!selectedTemplate) {
            alert('Please select a template first');
            return;
        }

        const formData = {
            template: selectedTemplate,
            personalInfo: {
                fullName: $('input[name="fullName"]').val(),
                email: $('input[name="email"]').val(),
                phone: $('input[name="phone"]').val(),
                location: $('input[name="location"]').val(),
                summary: $('textarea[name="summary"]').val()
            },
            education: [],
            experience: [],
            skills: {
                skills: $('textarea[name="skills"]').val(),
                languages: $('textarea[name="languages"]').val(),
                certifications: $('textarea[name="certifications"]').val()
            }
        };

        // Collect education entries
        $('.education-entry').each(function () {
            formData.education.push({
                degree: $(this).find('input[name="degree[]"]').val(),
                institution: $(this).find('input[name="institution[]"]').val(),
                startDate: $(this).find('input[name="eduStartDate[]"]').val(),
                endDate: $(this).find('input[name="eduEndDate[]"]').val()
            });
        });

        // Collect experience entries
        $('.experience-entry').each(function () {
            formData.experience.push({
                jobTitle: $(this).find('input[name="jobTitle[]"]').val(),
                company: $(this).find('input[name="company[]"]').val(),
                startDate: $(this).find('input[name="expStartDate[]"]').val(),
                endDate: $(this).find('input[name="expEndDate[]"]').val(),
                responsibilities: $(this).find('textarea[name="responsibilities[]"]').val()
            });
        });

        // Show loading state
        $('#generateResume').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Generating...');

        // Send AJAX request
        $.ajax({
            url: './controller/generate.php',
            method: 'POST',
            contentType: 'application/json',
            dataType: 'json',
            data: JSON.stringify(formData),
            success: function (response) {
                if (response.success) {
                    $('#resumePreview').html(response.resume);
                } else {
                    alert('Failed to generate resume: ' + response.error);
                }
            },
            error: function () {
                alert('An error occurred while generating the resume');
            },
            complete: function () {
                $('#generateResume').prop('disabled', false).html('<i class="fas fa-magic me-2"></i>Generate Resume');
            }
        });
    });
});
