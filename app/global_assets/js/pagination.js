const pagination = document.getElementById('pagination');
const currentPage = 1;
const totalPages = 10;

for (let i = 1; i <= totalPages; i++) {
  const link = document.createElement('a');
  link.href = '#';
  link.textContent = i;
  link.classList.add('px-3', 'py-2', 'text-gray-500', 'hover:bg-gray-100');
  
  if (i === currentPage) {
    link.classList.add('bg-gray-200', 'text-gray-600');
  }
  
  pagination.appendChild(link);
}