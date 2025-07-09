const enums = {
    status: {
        'ACTIVE': 1,
        'IN_ACTIVE': 2
    },
    payment_method: {
        'cod': 1,
        'paypal': 2,
        'stripe': 3,
        'wallet': 4
    },
    order_delivery_status: {
        'DELIVERED': 1,
        'PENDING': 2,
        'PROCESSING': 5,
        'SHIPPED': 3,
        'CANCELLED': 4,
        'READY_TO_SHIP': 6,
    },
    order_return_status: {
        'NOT_AVAILABLE': 1,
        'AVAILABLE': 2,
        'RETURNED': 3,
        'PROCESSING': 4,
        'CANCELLED': 5,
    },
    wallet_recharge_type: {
        'ONLINE': 1,
        'OFFLINE': 2,
    },
    wallet_recharge_status: {
        'ACCEPT': 1,
        'DECLINED': 2,
        'PENDING': 3
    },
    return_request_status: {
        'APPROVED': 1,
        'PENDING': 2,
        'PROCESSING': 3,
        'CANCELLED': 4,
        'PRODUCT_RECEIVED': 5
    },
    return_request_payment_status: {
        'PENDING': 2,
        'REFUNDED': 1,
    },
}

export default enums;