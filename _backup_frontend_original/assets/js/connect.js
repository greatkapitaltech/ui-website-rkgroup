// Contact Form Handler
document.addEventListener('DOMContentLoaded', function() {
  const contactForm = document.getElementById('contactForm');

  if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
      e.preventDefault();

      // Get form data
      const formData = {
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        interest: document.getElementById('interest').value,
        subject: document.getElementById('subject').value,
        message: document.getElementById('message').value
      };

      // TODO: Replace this with actual form submission logic
      // For now, just log the data and show a success message
      console.log('Form submitted:', formData);

      // Show success message
      alert('Thank you for reaching out! We will get back to you soon.');

      // Reset form
      contactForm.reset();

      // TODO: Implement actual form submission
      // You can send this data to a backend API or email service
      // Example:
      // fetch('/api/contact', {
      //   method: 'POST',
      //   headers: {
      //     'Content-Type': 'application/json',
      //   },
      //   body: JSON.stringify(formData)
      // })
      // .then(response => response.json())
      // .then(data => {
      //   alert('Thank you! We will get back to you soon.');
      //   contactForm.reset();
      // })
      // .catch(error => {
      //   alert('Sorry, there was an error. Please try again.');
      //   console.error('Error:', error);
      // });
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
