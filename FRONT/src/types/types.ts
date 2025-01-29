export interface Campaign {
    id: number | string;
    title: string;
    description: string;
    url_image: string;
    slug: string;
    target_amount: number;
    collected_amount: number;
    created_at: Date;
    limit_date: Date;
    closing_date: Date;
    category_id: number;
    user?: User;
    participants?: Participant[] | []
}

export interface Participant {
    id: number | string;
    name: string;
    amount: number;
    participation_date: Date;
}

interface User {
    id: number | string;
    name: string;
    first_name: string;
    public_name: string;
    email: string;
    birth_date: Date;
    subscribe_date: Date;
    image_profile: string;
}