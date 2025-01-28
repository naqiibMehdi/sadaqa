export interface Campaign {
    id: number;
    title: string;
    description: string;
    url_image: string;
    slug: string;
    target_amount: number;
    collected_amount: number;
    created_at: string;
    limit_date: string | null;
    closing_date: string | null;
    category_id: number;
    user: User;
    participants: Participant[]
}

interface Participant {
    id: number;
    name: string;
    amount: number;
    participation_date: string;
}

interface User {
    id: number;
    name: string;
    first_name: string;
    public_name: string;
    email: string;
    birth_date: string;
    subscribe_date: string;
    image_profile: string;
}