<?php

enum OrderStatus
{
    case Pending;
    case Shipped;
    case Delivered;
}

function getDeliveryMessage(OrderStatus $status): string
{
    return match ($status) {
        OrderStatus::Pending => 'Заказ в ожидании',
        OrderStatus::Shipped => 'Заказ отправлен',
        OrderStatus::Delivered => 'Заказ доставлен',
    };
}

