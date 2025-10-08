<?php

namespace App\Livewire;

use App\Models\AccompanimentRequest;
use Livewire\Component;

class AccompanimentForm extends Component
{
    public $currentStep = 1;

    public $totalSteps = 3;

    // Step 1: Personal Information
    public $first_name = '';

    public $last_name = '';

    public $country_residence = '';

    public $age = '';

    public $profession = '';

    public $email = '';

    public $phone = '';

    // Step 2: Project Information
    public $desired_city = '';

    public $property_type = '';

    public $budget_range = '';

    public $additional_info = '';

    // Step 3: Financial Information
    public $personal_contribution_percentage = 20;
    
    // Additional financial fields
    public $monthly_income = '';
    public $existing_debt = '';
    public $loan_duration = 20; // years
    public $interest_rate = 11.5; // South African average
    
    public $showSuccess = false;

    protected function rules()
    {
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'country_residence' => 'required|string|max:255',
            'age' => 'required|integer|min:18|max:100',
            'profession' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ];

        if ($this->currentStep >= 2) {
            $rules = array_merge($rules, [
                'desired_city' => 'required|string|max:255',
                'property_type' => 'required|string|max:255',
                'budget_range' => 'required|string|max:255',
            ]);
        }

        if ($this->currentStep >= 3) {
            $rules = array_merge($rules, [
                'personal_contribution_percentage' => 'required|integer|min:10|max:100',
                'monthly_income' => 'required|numeric|min:0',
                'existing_debt' => 'nullable|numeric|min:0',
                'loan_duration' => 'required|integer|min:5|max:30',
            ]);
        }

        return $rules;
    }

    protected $messages = [
        'first_name.required' => 'Le prénom est requis',
        'last_name.required' => 'Le nom est requis',
        'country_residence.required' => 'Le pays de résidence est requis',
        'age.required' => 'L\'âge est requis',
        'age.integer' => 'L\'âge doit être un nombre',
        'age.min' => 'Vous devez être majeur',
        'profession.required' => 'La profession est requise',
        'email.required' => 'L\'email est requis',
        'email.email' => 'L\'email doit être valide',
        'phone.required' => 'Le téléphone est requis',
        'desired_city.required' => 'La ville souhaitée est requise',
        'property_type.required' => 'Le type de bien est requis',
        'budget_range.required' => 'Le budget est requis',
        'personal_contribution_percentage.required' => 'L\'apport personnel est requis',
        'monthly_income.required' => 'Le revenu mensuel est requis',
        'monthly_income.numeric' => 'Le revenu doit être un nombre',
        'existing_debt.numeric' => 'Les dettes doivent être un nombre',
        'loan_duration.required' => 'La durée du prêt est requise',
        'loan_duration.integer' => 'La durée doit être un nombre entier',
        'loan_duration.min' => 'La durée minimum est de 5 ans',
        'loan_duration.max' => 'La durée maximum est de 30 ans',
    ];

    public function nextStep()
    {
        $this->validateCurrentStep();

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    private function validateCurrentStep()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'country_residence' => 'required|string|max:255',
                'age' => 'required|integer|min:18|max:100',
                'profession' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
            ]);
        } elseif ($this->currentStep == 2) {
            $this->validate([
                'desired_city' => 'required|string|max:255',
                'property_type' => 'required|string|max:255',
                'budget_range' => 'required|string|max:255',
            ]);
        }
    }

    public function submitRequest()
    {
        $this->validate();

        AccompanimentRequest::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'country_residence' => $this->country_residence,
            'age' => $this->age,
            'profession' => $this->profession,
            'email' => $this->email,
            'phone' => $this->phone,
            'desired_city' => $this->desired_city,
            'property_type' => $this->property_type,
            'budget_range' => $this->budget_range,
            'additional_info' => $this->additional_info,
            'personal_contribution_percentage' => $this->personal_contribution_percentage,
            'monthly_income' => $this->monthly_income,
            'existing_debt' => $this->existing_debt,
            'loan_duration' => $this->loan_duration,
        ]);

        $this->reset();
        $this->currentStep = 1;
        $this->showSuccess = true;
    }

    public function getStepTitleProperty()
    {
        return match ($this->currentStep) {
            1 => 'Informations Personnelles',
            2 => 'Votre Projet Immobilier',
            3 => 'Apport Personnel',
            default => 'Étape '.$this->currentStep
        };
    }

    public function getStepDescriptionProperty()
    {
        return match ($this->currentStep) {
            1 => 'Parlez-nous de vous',
            2 => 'Décrivez le bien de vos rêves',
            3 => 'Définissez votre capacité de financement',
            default => ''
        };
    }

    // Financial calculation methods
    public function getBudgetMinProperty()
    {
        if (!$this->budget_range) return 0;
        
        $range = explode(' - ', str_replace([' ZAR', ' 000'], ['', '000'], $this->budget_range));
        return (int) str_replace([' ', ','], '', $range[0]);
    }

    public function getBudgetMaxProperty()
    {
        if (!$this->budget_range) return 0;
        
        if (str_contains($this->budget_range, 'Plus de')) {
            return 15000000; // Cap for calculations
        }
        
        $range = explode(' - ', str_replace([' ZAR', ' 000'], ['', '000'], $this->budget_range));
        return isset($range[1]) ? (int) str_replace([' ', ','], '', $range[1]) : $this->getBudgetMinProperty();
    }

    public function getAverageBudgetProperty()
    {
        return ($this->getBudgetMinProperty() + $this->getBudgetMaxProperty()) / 2;
    }

    public function getPersonalContributionAmountProperty()
    {
        return $this->getAverageBudgetProperty() * ($this->personal_contribution_percentage / 100);
    }

    public function getLoanAmountProperty()
    {
        return $this->getAverageBudgetProperty() - $this->getPersonalContributionAmountProperty();
    }

    public function getMonthlyPaymentProperty()
    {
        $principal = $this->getLoanAmountProperty();
        $monthlyRate = ($this->interest_rate / 100) / 12;
        $numberOfPayments = $this->loan_duration * 12;

        if ($monthlyRate == 0) {
            return $principal / $numberOfPayments;
        }

        return $principal * ($monthlyRate * pow(1 + $monthlyRate, $numberOfPayments)) / 
               (pow(1 + $monthlyRate, $numberOfPayments) - 1);
    }

    public function getAffordabilityRatioProperty()
    {
        if (!$this->monthly_income || $this->monthly_income == 0) return 0;
        
        $totalDebt = $this->getMonthlyPaymentProperty() + (float) ($this->existing_debt ?? 0);
        return ($totalDebt / (float) $this->monthly_income) * 100;
    }

    public function getAffordabilityStatusProperty()
    {
        $ratio = $this->getAffordabilityRatioProperty();
        
        if ($ratio <= 30) return ['status' => 'excellent', 'color' => 'green', 'message' => 'Excellent profil financier'];
        if ($ratio <= 40) return ['status' => 'good', 'color' => 'blue', 'message' => 'Profil financier solide'];
        if ($ratio <= 50) return ['status' => 'acceptable', 'color' => 'yellow', 'message' => 'Profil acceptable'];
        return ['status' => 'risky', 'color' => 'red', 'message' => 'Profil à risque'];
    }

    public function render()
    {
        return view('livewire.accompaniment-form')->layout('layouts.site');
    }
}
