// Contact Form Handler
document.addEventListener('DOMContentLoaded', function() {
  const contactForm = document.getElementById('contactForm');

  // Create notification container if it doesn't exist
  if (!document.getElementById('notification-container')) {
    const notificationContainer = document.createElement('div');
    notificationContainer.id = 'notification-container';
    notificationContainer.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999;';
    document.body.appendChild(notificationContainer);
  }

  // Function to show notification
  function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show`;
    notification.style.cssText = 'min-width: 300px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);';
    notification.innerHTML = `
      <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    document.getElementById('notification-container').appendChild(notification);

    // Auto-dismiss after 5 seconds
    setTimeout(() => {
      notification.classList.remove('show');
      setTimeout(() => notification.remove(), 150);
    }, 5000);
  }

  if (contactForm) {
    const submitButton = contactForm.querySelector('button[type="submit"]');
    const originalButtonText = submitButton.innerHTML;

    contactForm.addEventListener('submit', function(e) {
      e.preventDefault();

      // Disable submit button and show loading state
      submitButton.disabled = true;
      submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Sending...';

      // Get form data (this will automatically include CSRF token)
      const formData = new FormData(contactForm);

      // Get base URL from form data attribute
      const baseUrl = contactForm.getAttribute('data-base-url') || '';
      const submitUrl = baseUrl + 'api/contact/submit';

      // Submit form to backend
      fetch(submitUrl, {
        method: 'POST',
        body: formData
      })
      .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);

        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
          return response.json();
        } else {
          // If not JSON, get text to see what we received
          return response.text().then(text => {
            console.error('Received non-JSON response:', text);
            throw new Error('Server returned invalid response');
          });
        }
      })
      .then(data => {
        console.log('Response data:', data);
        if (data.success) {
          showNotification(data.message, 'success');
          contactForm.reset();
          // Remove validation classes
          const inputs = contactForm.querySelectorAll('input, select, textarea');
          inputs.forEach(input => {
            input.classList.remove('is-valid', 'is-invalid');
          });
        } else {
          showNotification(data.message || 'An error occurred', 'danger');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showNotification('Sorry, there was an error processing your request. Please try again.', 'danger');
      })
      .finally(() => {
        // Re-enable submit button
        submitButton.disabled = false;
        submitButton.innerHTML = originalButtonText;
      });
    });
  }

  // Form validation styling
  const inputs = contactForm.querySelectorAll('input, select, textarea');
  inputs.forEach(input => {
    input.addEventListener('blur', function() {
      if (this.value.trim() === '' && this.hasAttribute('required')) {
        this.classList.add('is-invalid');
      } else {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
      }
    });

    input.addEventListener('input', function() {
      if (this.classList.contains('is-invalid')) {
        this.classList.remove('is-invalid');
        if (this.value.trim() !== '') {
          this.classList.add('is-valid');
        }
      }
    });
  });

  // Phone number formatting (optional)
  const phoneInput = document.getElementById('phone');
  if (phoneInput) {
    phoneInput.addEventListener('input', function(e) {
      let value = e.target.value.replace(/\D/g, '');
      if (value.length > 10) {
        value = value.slice(0, 10);
      }
      e.target.value = value;
    });
  }
});
