export interface RegisterUser {
  name: string,
  first_name: string,
  public_name: string,
  email: string,
  password: string,
  password_confirmation: string,
  birth_date: string
}

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
  closing_date: Date | string;
  category_id: number;
  is_anonymous: boolean;
  user?: User;
  participants?: Participant[] | [],
  recovery?: CampaignRecovery | null,
}

export interface CampaignRecovery {
  id: number;
  campaign_id: number;
  user_id: number;
  total_amount: number;
  status: 'pending' | 'processed' | 'failed';
  created_at: string;
  campaign?: Campaign;
}

export interface Participant {
  id: number | string;
  title?: string
  name: string;
  amount: number;
  participation_date: Date | string;
  status: 'pending' | 'completed' | 'cancelled' | "refunded" | "failed";
}

export interface User {
  id?: number | string;
  name: string;
  first_name: string;
  public_name?: string;
  email: string;
  birth_date: Date;
  subscribe_date?: Date;
  image_profile: string;
}

export interface Address {
  id?: number,
  address: string,
  city: string,
  postal_code: string,
  country: string,
}

export interface errorsFormCampaign {
  title: string,
  description: string,
  image: string | { max?: string, mimes?: string }[],
  target_amount: string,
  category_id: string,
  is_anonymous: boolean,
}