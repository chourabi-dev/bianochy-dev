$(document).ready(function(){
    AOS.init();

    // init all owl carrousels
    $('.carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items: 1
            }
        }
    })


    $('#hero').owlCarousel({
      loop:true,
      margin:10,
      nav:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items: 1
            }
        }
    })




    

    

    // init starts
    var stars = new StarRating('.star-rating',{
        tooltip: false,
    });




    





    const cartKey = "shoppingCart";
    const packCartKey = "packCart";
    const cartPanel = $("#cart-panel");
    
    // Open Cart Panel
    function openCartPanel() {
      cartPanel.addClass('visible');
      displayCartItems();
    }
    
    // Close Cart Panel
    $('#close-cart').on('click', function () {
      cartPanel.removeClass('visible');
    });
    
    // Fetch product details from API
    async function fetchProductDetails(productId) {
      const response = await fetch(`/api/details/product/${productId}`);
      return response.json();
    }
    
    // Fetch pack details from API
    async function fetchPackDetails(packId) {
      const response = await fetch(`/api/details/pack/${packId}`);
      return response.json();
    }
    
    // Display all items (products and packs) in the cart
    async function displayCartItems() {
      const products = JSON.parse(localStorage.getItem(cartKey)) || [];
      const packs = JSON.parse(localStorage.getItem(packCartKey)) || [];
      let cartHTML = '';
      let totalPrice = 0;
    
      // Display products
      for (let product of products) {
        const productData = await fetchProductDetails(product.id);
        const { title, imageUrl, price } = productData;
    
        totalPrice += price * product.quantity;
    
        cartHTML += `
          <div class="cart-item product-item" data-product-id="${product.id}">
            <img src="${imageUrl}" alt="${title}" />
            <div class="w-100">
              <h4>${title}</h4>
              <p class="badge bg-dark">Product</p>
              <p>${price} TND</p>
              <div class="remove-btn">
                <i class="fa fa-trash btn btn-sm btn-danger"></i>
              </div>
            </div>
            <div>
              <button class="quantity-btn decrease btn btn-sm btn-secondary mb-3">-</button>
              <div class="quantity text-center">${product.quantity}</div>
              <button class="quantity-btn increase btn btn-sm btn-secondary mt-3">+</button>
            </div>
          </div>
        `;
      }
    
      // Display packs
      for (let pack of packs) {
        const packData = await fetchPackDetails(pack.id);
        const { title, imageUrl, price } = packData;
    
        totalPrice += price * pack.quantity;
    
        cartHTML += `
          <div class="cart-item pack-item" data-pack-id="${pack.id}">
            <img src="${imageUrl}" alt="${title}" />
            <div class="w-100">
              <h4>${title}</h4>
              <p class="badge bg-dark">Pack</p>
              <p>${price} TND</p>
              <div class="remove-btn">
                <i class="fa fa-trash btn btn-sm btn-danger"></i>
              </div>
            </div>
            <div>
              <button class="quantity-btn decrease btn btn-sm btn-secondary mb-3">-</button>
              <div class="quantity text-center">${pack.quantity}</div>
              <button class="quantity-btn increase btn btn-sm btn-secondary mt-3">+</button>
            </div>
          </div>
        `;
      }
    
      $("#cart-items").html(cartHTML);
      $("#cart-total").text(totalPrice.toFixed(2));
    
      // Handle quantity updates and removal
      $(".product-item .decrease").on("click", handleDecreaseProductQuantity);
      $(".product-item .increase").on("click", handleIncreaseProductQuantity);
      $(".product-item .remove-btn").on("click", handleRemoveProduct);
      
      $(".pack-item .decrease").on("click", handleDecreasePackQuantity);
      $(".pack-item .increase").on("click", handleIncreasePackQuantity);
      $(".pack-item .remove-btn").on("click", handleRemovePack);
    }
    
    // Product handlers
    function handleDecreaseProductQuantity() {
      const productId = $(this).closest('.product-item').data('product-id');
      updateCartProductQuantity(productId, -1);
    }
    
    function handleIncreaseProductQuantity() {
      const productId = $(this).closest('.product-item').data('product-id');
      updateCartProductQuantity(productId, 1);
    }
    
    function updateCartProductQuantity(productId, change) {
      let cart = JSON.parse(localStorage.getItem(cartKey)) || [];
      const productIndex = cart.findIndex(product => product.id == productId);
    
      if (productIndex != -1) {
        cart[productIndex].quantity += change;
        if (cart[productIndex].quantity <= 0) {
          cart.splice(productIndex, 1);
        }
        localStorage.setItem(cartKey, JSON.stringify(cart));
        displayCartItems();
      }
    }
    
    function handleRemoveProduct() {
      const productId = $(this).closest('.product-item').data('product-id');
      let cart = JSON.parse(localStorage.getItem(cartKey)) || [];
      cart = cart.filter(product => product.id != productId);
      localStorage.setItem(cartKey, JSON.stringify(cart));
      displayCartItems();
    }
    
    // Pack handlers
    function handleDecreasePackQuantity() {
      const packId = $(this).closest('.pack-item').data('pack-id');
      updateCartPackQuantity(packId, -1);
    }
    
    function handleIncreasePackQuantity() {
      const packId = $(this).closest('.pack-item').data('pack-id');
      updateCartPackQuantity(packId, 1);
    }
    
    function updateCartPackQuantity(packId, change) {
      let packs = JSON.parse(localStorage.getItem(packCartKey)) || [];
      const packIndex = packs.findIndex(pack => pack.id == packId);
    
      if (packIndex != -1) {
        packs[packIndex].quantity += change;
        if (packs[packIndex].quantity <= 0) {
          packs.splice(packIndex, 1);
        }
        localStorage.setItem(packCartKey, JSON.stringify(packs));
        displayCartItems();
      }
    }
    
    function handleRemovePack() {
      const packId = $(this).closest('.pack-item').data('pack-id');
      let packs = JSON.parse(localStorage.getItem(packCartKey)) || [];
      packs = packs.filter(pack => pack.id != packId);
      localStorage.setItem(packCartKey, JSON.stringify(packs));
      displayCartItems();
    }
    
    // Add product to cart
    $(".add-product-cart").click(function(){
        let productID = $(this).attr('product-id');
        let cart = JSON.parse(localStorage.getItem(cartKey)) || [];
        let productIndex = cart.findIndex(product => product.id === productID);
    
        if (productIndex === -1) {
            cart.push({ id: productID, quantity: 1 });
            localStorage.setItem(cartKey, JSON.stringify(cart));
        }
    
        openCartPanel();
    });
    
    // Add pack to cart
    $(".add-pack-cart").click(function(){
        let packID = $(this).attr('pack-id');
        let packs = JSON.parse(localStorage.getItem(packCartKey)) || [];
        let packIndex = packs.findIndex(pack => pack.id === packID);
    
        if (packIndex === -1) {
            packs.push({ id: packID, quantity: 1 });
            localStorage.setItem(packCartKey, JSON.stringify(packs));
        }
    
        openCartPanel();
    });
    
    $("#nav-bar-open-cart").click(function(e){
      e.preventDefault();
      console.log("clicked");
      
      openCartPanel();
  })
  

  $("#nav-bar-open-cart-web").click(function(e){
    e.preventDefault();
    console.log("clicked");
    
    openCartPanel();
})






 



})