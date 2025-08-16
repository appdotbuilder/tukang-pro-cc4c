export interface Craftsman {
    id: number;
    user_id: number;
    bio: string | null;
    years_experience: number;
    hourly_rate: number | null;
    location: string | null;
    rating: number;
    total_reviews: number;
    work_areas: string[] | null;
    profile_photo: string | null;
    is_available: boolean;
    is_verified: boolean;
    insurance_rate: number;
    created_at: string;
    updated_at: string;
    user: {
        id: number;
        name: string;
        email: string;
        role: string;
        phone: string | null;
        address: string | null;
    };
    skills: {
        id: number;
        skill: {
            id: number;
            name: string;
            description: string | null;
            base_rate: number;
        };
        certification: {
            id: number;
            name: string;
            level: string;
            rate_multiplier: number;
        } | null;
    }[];
}

export interface Skill {
    id: number;
    name: string;
    description: string | null;
    base_rate: number;
    is_active: boolean;
}

export interface ServiceRequest {
    id: number;
    customer_id: number;
    craftsman_id: number | null;
    skill_id: number;
    title: string;
    description: string;
    location: string;
    estimated_budget: number | null;
    preferred_date: string | null;
    status: string;
    final_amount: number | null;
    created_at: string;
    updated_at: string;
}