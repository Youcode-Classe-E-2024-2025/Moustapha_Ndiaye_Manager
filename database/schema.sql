CREATE DATABASE IF NOT EXISTS recipeDB;
USE recipeDB;

-- USERS Table 
CREATE TABLE IF NOT EXISTS USERS (
    user_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    Fname VARCHAR(100) NOT NULL,
    Lname VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE, 
    password_hash VARBINARY(255) NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user'  -- Rôle de l'utilisateur
);

-- RECIPE_CATEGORY Table 
CREATE TABLE IF NOT EXISTS RECIPE_CATEGORY (
    category_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- RECIPE Table 
CREATE TABLE IF NOT EXISTS RECIPE (
    recipe_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    user_id INTEGER NOT NULL,
    category_id INTEGER NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    preparation_time INTEGER,
    cooking_time INTEGER,
    servings INTEGER,
    difficulty ENUM('easy', 'medium', 'hard') NOT NULL,
    creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES USERS(user_id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES RECIPE_CATEGORY(category_id) ON DELETE RESTRICT
);

-- INGREDIENT Table 
CREATE TABLE IF NOT EXISTS INGREDIENT (
    ingredient_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    is_vegetarian BOOLEAN DEFAULT FALSE,
    is_vegan BOOLEAN DEFAULT FALSE
);

-- RECIPE_INGREDIENT Table 
CREATE TABLE IF NOT EXISTS RECIPE_INGREDIENT (
    recipe_id INTEGER,
    ingredient_id INTEGER,
    quantity DECIMAL(10, 2) NOT NULL,
    unit VARCHAR(50) NOT NULL,
    notes TEXT,
    PRIMARY KEY (recipe_id, ingredient_id),
    FOREIGN KEY (recipe_id) REFERENCES RECIPE(recipe_id) ON DELETE CASCADE,
    FOREIGN KEY (ingredient_id) REFERENCES INGREDIENT(ingredient_id) ON DELETE RESTRICT
);

-- COMMENT Table 
CREATE TABLE IF NOT EXISTS COMMENT (
    comment_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    recipe_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    content TEXT NOT NULL,
    creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (recipe_id) REFERENCES RECIPE(recipe_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES USERS(user_id) ON DELETE CASCADE
);

-- RATING Table 
CREATE TABLE IF NOT EXISTS RATING (
    rating_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    recipe_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    score TINYINT CHECK (score BETWEEN 1 AND 5),
    creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_recipe_rating (user_id, recipe_id),
    FOREIGN KEY (recipe_id) REFERENCES RECIPE(recipe_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES USERS(user_id) ON DELETE CASCADE
);

-- SESSION Table 
CREATE TABLE IF NOT EXISTS SESSION (
    session_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    user_id INTEGER,  -- Référence uniquement à l'utilisateur
    session_token VARCHAR(255) NOT NULL UNIQUE,
    ip_address VARCHAR(45),
    user_agent VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    expired BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES USERS(user_id) ON DELETE CASCADE
);

-- Add indexes for performance
CREATE INDEX idx_recipe_user ON RECIPE(user_id);
CREATE INDEX idx_recipe_category ON RECIPE(category_id);
CREATE INDEX idx_comment_recipe ON COMMENT(recipe_id);
CREATE INDEX idx_rating_recipe ON RATING(recipe_id);
