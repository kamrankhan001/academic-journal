<?php
// database/seeders/TagSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            // General Academic Categories
            ['name' => 'Research', 'slug' => 'research'],
            ['name' => 'Review Article', 'slug' => 'review-article'],
            ['name' => 'Original Research', 'slug' => 'original-research'],
            ['name' => 'Case Study', 'slug' => 'case-study'],
            ['name' => 'Clinical Trial', 'slug' => 'clinical-trial'],
            ['name' => 'Meta-Analysis', 'slug' => 'meta-analysis'],
            ['name' => 'Systematic Review', 'slug' => 'systematic-review'],
            ['name' => 'Methodology', 'slug' => 'methodology'],
            ['name' => 'Theoretical Framework', 'slug' => 'theoretical-framework'],
            ['name' => 'Literature Review', 'slug' => 'literature-review'],
            
            // STEM Fields
            ['name' => 'Physics', 'slug' => 'physics'],
            ['name' => 'Quantum Mechanics', 'slug' => 'quantum-mechanics'],
            ['name' => 'Astrophysics', 'slug' => 'astrophysics'],
            ['name' => 'Cosmology', 'slug' => 'cosmology'],
            ['name' => 'Particle Physics', 'slug' => 'particle-physics'],
            ['name' => 'Nuclear Physics', 'slug' => 'nuclear-physics'],
            ['name' => 'Condensed Matter', 'slug' => 'condensed-matter'],
            ['name' => 'Optics', 'slug' => 'optics'],
            ['name' => 'Photonics', 'slug' => 'photonics'],
            ['name' => 'Thermodynamics', 'slug' => 'thermodynamics'],
            
            // Chemistry
            ['name' => 'Chemistry', 'slug' => 'chemistry'],
            ['name' => 'Organic Chemistry', 'slug' => 'organic-chemistry'],
            ['name' => 'Inorganic Chemistry', 'slug' => 'inorganic-chemistry'],
            ['name' => 'Physical Chemistry', 'slug' => 'physical-chemistry'],
            ['name' => 'Analytical Chemistry', 'slug' => 'analytical-chemistry'],
            ['name' => 'Biochemistry', 'slug' => 'biochemistry'],
            ['name' => 'Polymer Chemistry', 'slug' => 'polymer-chemistry'],
            ['name' => 'Medicinal Chemistry', 'slug' => 'medicinal-chemistry'],
            ['name' => 'Environmental Chemistry', 'slug' => 'environmental-chemistry'],
            ['name' => 'Computational Chemistry', 'slug' => 'computational-chemistry'],
            
            // Biology
            ['name' => 'Biology', 'slug' => 'biology'],
            ['name' => 'Molecular Biology', 'slug' => 'molecular-biology'],
            ['name' => 'Cell Biology', 'slug' => 'cell-biology'],
            ['name' => 'Genetics', 'slug' => 'genetics'],
            ['name' => 'Genomics', 'slug' => 'genomics'],
            ['name' => 'Proteomics', 'slug' => 'proteomics'],
            ['name' => 'Evolutionary Biology', 'slug' => 'evolutionary-biology'],
            ['name' => 'Ecology', 'slug' => 'ecology'],
            ['name' => 'Marine Biology', 'slug' => 'marine-biology'],
            ['name' => 'Microbiology', 'slug' => 'microbiology'],
            
            // Medicine & Health
            ['name' => 'Medicine', 'slug' => 'medicine'],
            ['name' => 'Cardiology', 'slug' => 'cardiology'],
            ['name' => 'Neurology', 'slug' => 'neurology'],
            ['name' => 'Oncology', 'slug' => 'oncology'],
            ['name' => 'Pediatrics', 'slug' => 'pediatrics'],
            ['name' => 'Psychiatry', 'slug' => 'psychiatry'],
            ['name' => 'Pharmacology', 'slug' => 'pharmacology'],
            ['name' => 'Immunology', 'slug' => 'immunology'],
            ['name' => 'Epidemiology', 'slug' => 'epidemiology'],
            ['name' => 'Public Health', 'slug' => 'public-health'],
            
            // Computer Science
            ['name' => 'Computer Science', 'slug' => 'computer-science'],
            ['name' => 'Artificial Intelligence', 'slug' => 'artificial-intelligence'],
            ['name' => 'Machine Learning', 'slug' => 'machine-learning'],
            ['name' => 'Deep Learning', 'slug' => 'deep-learning'],
            ['name' => 'Data Science', 'slug' => 'data-science'],
            ['name' => 'Big Data', 'slug' => 'big-data'],
            ['name' => 'Algorithms', 'slug' => 'algorithms'],
            ['name' => 'Data Structures', 'slug' => 'data-structures'],
            ['name' => 'Programming Languages', 'slug' => 'programming-languages'],
            ['name' => 'Software Engineering', 'slug' => 'software-engineering'],
            
            // Engineering
            ['name' => 'Engineering', 'slug' => 'engineering'],
            ['name' => 'Electrical Engineering', 'slug' => 'electrical-engineering'],
            ['name' => 'Mechanical Engineering', 'slug' => 'mechanical-engineering'],
            ['name' => 'Civil Engineering', 'slug' => 'civil-engineering'],
            ['name' => 'Chemical Engineering', 'slug' => 'chemical-engineering'],
            ['name' => 'Biomedical Engineering', 'slug' => 'biomedical-engineering'],
            ['name' => 'Aerospace Engineering', 'slug' => 'aerospace-engineering'],
            ['name' => 'Robotics', 'slug' => 'robotics'],
            ['name' => 'Mechatronics', 'slug' => 'mechatronics'],
            ['name' => 'Nanotechnology', 'slug' => 'nanotechnology'],
            
            // Mathematics
            ['name' => 'Mathematics', 'slug' => 'mathematics'],
            ['name' => 'Pure Mathematics', 'slug' => 'pure-mathematics'],
            ['name' => 'Applied Mathematics', 'slug' => 'applied-mathematics'],
            ['name' => 'Statistics', 'slug' => 'statistics'],
            ['name' => 'Probability', 'slug' => 'probability'],
            ['name' => 'Algebra', 'slug' => 'algebra'],
            ['name' => 'Calculus', 'slug' => 'calculus'],
            ['name' => 'Geometry', 'slug' => 'geometry'],
            ['name' => 'Topology', 'slug' => 'topology'],
            ['name' => 'Number Theory', 'slug' => 'number-theory'],
            
            // Social Sciences
            ['name' => 'Social Sciences', 'slug' => 'social-sciences'],
            ['name' => 'Psychology', 'slug' => 'psychology'],
            ['name' => 'Sociology', 'slug' => 'sociology'],
            ['name' => 'Anthropology', 'slug' => 'anthropology'],
            ['name' => 'Political Science', 'slug' => 'political-science'],
            ['name' => 'Economics', 'slug' => 'economics'],
            ['name' => 'Geography', 'slug' => 'geography'],
            ['name' => 'History', 'slug' => 'history'],
            ['name' => 'Philosophy', 'slug' => 'philosophy'],
            ['name' => 'Linguistics', 'slug' => 'linguistics'],
            
            // Business & Management
            ['name' => 'Business', 'slug' => 'business'],
            ['name' => 'Management', 'slug' => 'management'],
            ['name' => 'Marketing', 'slug' => 'marketing'],
            ['name' => 'Finance', 'slug' => 'finance'],
            ['name' => 'Accounting', 'slug' => 'accounting'],
            ['name' => 'Entrepreneurship', 'slug' => 'entrepreneurship'],
            ['name' => 'Organizational Behavior', 'slug' => 'organizational-behavior'],
            ['name' => 'Human Resources', 'slug' => 'human-resources'],
            ['name' => 'Strategic Management', 'slug' => 'strategic-management'],
            ['name' => 'International Business', 'slug' => 'international-business'],
            
            // Education
            ['name' => 'Education', 'slug' => 'education'],
            ['name' => 'Teaching Methods', 'slug' => 'teaching-methods'],
            ['name' => 'Curriculum Development', 'slug' => 'curriculum-development'],
            ['name' => 'Educational Technology', 'slug' => 'educational-technology'],
            ['name' => 'Higher Education', 'slug' => 'higher-education'],
            ['name' => 'Distance Learning', 'slug' => 'distance-learning'],
            ['name' => 'Special Education', 'slug' => 'special-education'],
            ['name' => 'Early Childhood Education', 'slug' => 'early-childhood-education'],
            ['name' => 'Educational Psychology', 'slug' => 'educational-psychology'],
            ['name' => 'Assessment', 'slug' => 'assessment'],
            
            // Environmental Science
            ['name' => 'Environmental Science', 'slug' => 'environmental-science'],
            ['name' => 'Climate Change', 'slug' => 'climate-change'],
            ['name' => 'Sustainability', 'slug' => 'sustainability'],
            ['name' => 'Renewable Energy', 'slug' => 'renewable-energy'],
            ['name' => 'Conservation', 'slug' => 'conservation'],
            ['name' => 'Biodiversity', 'slug' => 'biodiversity'],
            ['name' => 'Ecosystems', 'slug' => 'ecosystems'],
            ['name' => 'Pollution', 'slug' => 'pollution'],
            ['name' => 'Environmental Policy', 'slug' => 'environmental-policy'],
            ['name' => 'Green Technology', 'slug' => 'green-technology'],
            
            // Agricultural Sciences
            ['name' => 'Agriculture', 'slug' => 'agriculture'],
            ['name' => 'Agronomy', 'slug' => 'agronomy'],
            ['name' => 'Crop Science', 'slug' => 'crop-science'],
            ['name' => 'Soil Science', 'slug' => 'soil-science'],
            ['name' => 'Horticulture', 'slug' => 'horticulture'],
            ['name' => 'Plant Pathology', 'slug' => 'plant-pathology'],
            ['name' => 'Food Science', 'slug' => 'food-science'],
            ['name' => 'Food Technology', 'slug' => 'food-technology'],
            ['name' => 'Nutrition', 'slug' => 'nutrition'],
            ['name' => 'Dietetics', 'slug' => 'dietetics'],
            
            // Earth Sciences
            ['name' => 'Earth Science', 'slug' => 'earth-science'],
            ['name' => 'Geology', 'slug' => 'geology'],
            ['name' => 'Geochemistry', 'slug' => 'geochemistry'],
            ['name' => 'Oceanography', 'slug' => 'oceanography'],
            ['name' => 'Meteorology', 'slug' => 'meteorology'],
            ['name' => 'Climatology', 'slug' => 'climatology'],
            ['name' => 'Seismology', 'slug' => 'seismology'],
            ['name' => 'Volcanology', 'slug' => 'volcanology'],
            ['name' => 'Paleontology', 'slug' => 'paleontology'],
            
            // Arts & Humanities
            ['name' => 'Arts', 'slug' => 'arts'],
            ['name' => 'Literature', 'slug' => 'literature'],
            ['name' => 'Poetry', 'slug' => 'poetry'],
            ['name' => 'Drama', 'slug' => 'drama'],
            ['name' => 'Music', 'slug' => 'music'],
            ['name' => 'Art History', 'slug' => 'art-history'],
            ['name' => 'Film Studies', 'slug' => 'film-studies'],
            ['name' => 'Cultural Studies', 'slug' => 'cultural-studies'],
            ['name' => 'Media Studies', 'slug' => 'media-studies'],
            ['name' => 'Communication', 'slug' => 'communication'],
            
            // Law & Politics
            ['name' => 'Law', 'slug' => 'law'],
            ['name' => 'Constitutional Law', 'slug' => 'constitutional-law'],
            ['name' => 'Criminal Law', 'slug' => 'criminal-law'],
            ['name' => 'International Law', 'slug' => 'international-law'],
            ['name' => 'Human Rights', 'slug' => 'human-rights'],
            ['name' => 'Public Policy', 'slug' => 'public-policy'],
            ['name' => 'Governance', 'slug' => 'governance'],
            ['name' => 'International Relations', 'slug' => 'international-relations'],
            ['name' => 'Diplomacy', 'slug' => 'diplomacy'],
            ['name' => 'Conflict Resolution', 'slug' => 'conflict-resolution'],
            
            // Interdisciplinary
            ['name' => 'Neuroscience', 'slug' => 'neuroscience'],
            ['name' => 'Cognitive Science', 'slug' => 'cognitive-science'],
            ['name' => 'Bioinformatics', 'slug' => 'bioinformatics'],
            ['name' => 'Biotechnology', 'slug' => 'biotechnology'],
            ['name' => 'Synthetic Biology', 'slug' => 'synthetic-biology'],
            ['name' => 'Systems Biology', 'slug' => 'systems-biology'],
            ['name' => 'Computational Biology', 'slug' => 'computational-biology'],
            ['name' => 'Biopsychology', 'slug' => 'biopsychology'],
            ['name' => 'Psychopharmacology', 'slug' => 'psychopharmacology'],
            
            // Emerging Fields
            ['name' => 'Quantum Computing', 'slug' => 'quantum-computing'],
            ['name' => 'Blockchain', 'slug' => 'blockchain'],
            ['name' => 'Cryptocurrency', 'slug' => 'cryptocurrency'],
            ['name' => 'Cybersecurity', 'slug' => 'cybersecurity'],
            ['name' => 'Internet of Things', 'slug' => 'internet-of-things'],
            ['name' => 'Edge Computing', 'slug' => 'edge-computing'],
            ['name' => 'Cloud Computing', 'slug' => 'cloud-computing'],
            ['name' => 'Virtual Reality', 'slug' => 'virtual-reality'],
            ['name' => 'Augmented Reality', 'slug' => 'augmented-reality'],
            ['name' => 'Mixed Reality', 'slug' => 'mixed-reality'],
            
            // More Specialized Tags
            ['name' => 'Stem Cells', 'slug' => 'stem-cells'],
            ['name' => 'Gene Editing', 'slug' => 'gene-editing'],
            ['name' => 'CRISPR', 'slug' => 'crispr'],
            ['name' => 'Epigenetics', 'slug' => 'epigenetics'],
            ['name' => 'Metabolomics', 'slug' => 'metabolomics'],
            ['name' => 'Transcriptomics', 'slug' => 'transcriptomics'],
            ['name' => 'Lipidomics', 'slug' => 'lipidomics'],
            ['name' => 'Glycomics', 'slug' => 'glycomics'],
            ['name' => 'Pharmacogenomics', 'slug' => 'pharmacogenomics'],
            ['name' => 'Toxicogenomics', 'slug' => 'toxicogenomics'],
            
            // Psychology Specializations
            ['name' => 'Clinical Psychology', 'slug' => 'clinical-psychology'],
            ['name' => 'Cognitive Psychology', 'slug' => 'cognitive-psychology'],
            ['name' => 'Developmental Psychology', 'slug' => 'developmental-psychology'],
            ['name' => 'Social Psychology', 'slug' => 'social-psychology'],
            ['name' => 'Forensic Psychology', 'slug' => 'forensic-psychology'],
            ['name' => 'Health Psychology', 'slug' => 'health-psychology'],
            ['name' => 'Sports Psychology', 'slug' => 'sports-psychology'],
            ['name' => 'Organizational Psychology', 'slug' => 'organizational-psychology'],
            ['name' => 'Positive Psychology', 'slug' => 'positive-psychology'],
            ['name' => 'Evolutionary Psychology', 'slug' => 'evolutionary-psychology'],
            
            // Medical Specialties
            ['name' => 'Dermatology', 'slug' => 'dermatology'],
            ['name' => 'Ophthalmology', 'slug' => 'ophthalmology'],
            ['name' => 'Otolaryngology', 'slug' => 'otolaryngology'],
            ['name' => 'Orthopedics', 'slug' => 'orthopedics'],
            ['name' => 'Rheumatology', 'slug' => 'rheumatology'],
            ['name' => 'Endocrinology', 'slug' => 'endocrinology'],
            ['name' => 'Gastroenterology', 'slug' => 'gastroenterology'],
            ['name' => 'Nephrology', 'slug' => 'nephrology'],
            ['name' => 'Pulmonology', 'slug' => 'pulmonology'],
            ['name' => 'Hematology', 'slug' => 'hematology'],
            
            // Physics Specializations
            ['name' => 'Plasma Physics', 'slug' => 'plasma-physics'],
            ['name' => 'Atomic Physics', 'slug' => 'atomic-physics'],
            ['name' => 'Molecular Physics', 'slug' => 'molecular-physics'],
            ['name' => 'Chemical Physics', 'slug' => 'chemical-physics'],
            ['name' => 'Geophysics', 'slug' => 'geophysics-2'],
            ['name' => 'Biophysics', 'slug' => 'biophysics-2'],
            ['name' => 'Medical Physics', 'slug' => 'medical-physics'],
            ['name' => 'Mathematical Physics', 'slug' => 'mathematical-physics'],
            ['name' => 'Computational Physics', 'slug' => 'computational-physics'],
            ['name' => 'Experimental Physics', 'slug' => 'experimental-physics'],
            
            // Chemistry Specializations
            ['name' => 'Quantum Chemistry', 'slug' => 'quantum-chemistry'],
            ['name' => 'Theoretical Chemistry', 'slug' => 'theoretical-chemistry'],
            ['name' => 'Nuclear Chemistry', 'slug' => 'nuclear-chemistry'],
            ['name' => 'Radiochemistry', 'slug' => 'radiochemistry'],
            ['name' => 'Green Chemistry', 'slug' => 'green-chemistry'],
            ['name' => 'Supramolecular Chemistry', 'slug' => 'supramolecular-chemistry'],
            ['name' => 'Materials Chemistry', 'slug' => 'materials-chemistry'],
            ['name' => 'Solid State Chemistry', 'slug' => 'solid-state-chemistry'],
            ['name' => 'Organometallic Chemistry', 'slug' => 'organometallic-chemistry'],
            ['name' => 'Photochemistry', 'slug' => 'photochemistry'],
            
            // Biology Specializations
            ['name' => 'Botany', 'slug' => 'botany'],
            ['name' => 'Zoology', 'slug' => 'zoology'],
            ['name' => 'Mycology', 'slug' => 'mycology'],
            ['name' => 'Virology', 'slug' => 'virology'],
            ['name' => 'Bacteriology', 'slug' => 'bacteriology'],
            ['name' => 'Parasitology', 'slug' => 'parasitology'],
            ['name' => 'Entomology', 'slug' => 'entomology'],
            ['name' => 'Ornithology', 'slug' => 'ornithology'],
            ['name' => 'Ichthyology', 'slug' => 'ichthyology'],
            ['name' => 'Herpetology', 'slug' => 'herpetology'],
            
            // Engineering Specializations
            ['name' => 'Structural Engineering', 'slug' => 'structural-engineering'],
            ['name' => 'Transportation Engineering', 'slug' => 'transportation-engineering'],
            ['name' => 'Geotechnical Engineering', 'slug' => 'geotechnical-engineering'],
            ['name' => 'Environmental Engineering', 'slug' => 'environmental-engineering'],
            ['name' => 'Water Resources Engineering', 'slug' => 'water-resources-engineering'],
            ['name' => 'Materials Engineering', 'slug' => 'materials-engineering'],
            ['name' => 'Manufacturing Engineering', 'slug' => 'manufacturing-engineering'],
            ['name' => 'Industrial Engineering', 'slug' => 'industrial-engineering'],
            ['name' => 'Systems Engineering', 'slug' => 'systems-engineering'],
            ['name' => 'Engineering Management', 'slug' => 'engineering-management'],
            
            // Computer Science Specializations
            ['name' => 'Computer Vision', 'slug' => 'computer-vision'],
            ['name' => 'Natural Language Processing', 'slug' => 'natural-language-processing'],
            ['name' => 'Speech Recognition', 'slug' => 'speech-recognition'],
            ['name' => 'Pattern Recognition', 'slug' => 'pattern-recognition'],
            ['name' => 'Computer Graphics', 'slug' => 'computer-graphics'],
            ['name' => 'Human-Computer Interaction', 'slug' => 'human-computer-interaction'],
            ['name' => 'Information Retrieval', 'slug' => 'information-retrieval'],
            ['name' => 'Knowledge Representation', 'slug' => 'knowledge-representation'],
            ['name' => 'Expert Systems', 'slug' => 'expert-systems'],
            ['name' => 'Fuzzy Logic', 'slug' => 'fuzzy-logic'],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}