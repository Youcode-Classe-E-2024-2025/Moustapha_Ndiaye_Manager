-- Table ADMIN
CREATE TABLE ADMIN (
    admin_id INTEGER PRIMARY KEY,
    Fname VARCHAR(255),
    Lname VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password_hash VARBINARY(255),
    role VARCHAR(50),
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP
);

-- Table USERS
CREATE TABLE USERS (
    user_id INTEGER PRIMARY KEY,
    Fname VARCHAR(255),
    Lname VARCHAR(255),
    email UNIQUEIDENTIFIER UNIQUE,
    password_hash VARBINARY(255),
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    role VARCHAR(50),
    admin_id INTEGER,
    FOREIGN KEY (admin_id) REFERENCES ADMIN(admin_id)
);

-- Table RECIPE_CATEGORY
CREATE TABLE RECIPE_CATEGORY (
    category_id INTEGER PRIMARY KEY,
    name VARCHAR(255),
    description TEXT
);

-- Table RECIPE
CREATE TABLE RECIPE (
    recipe_id INTEGER PRIMARY KEY,
    user_id INTEGER,
    category_id INTEGER,
    title VARCHAR(255),
    description TEXT,
    creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES USERS(user_id),
    FOREIGN KEY (category_id) REFERENCES RECIPE_CATEGORY(category_id)
);

-- Table INGREDIENT
CREATE TABLE INGREDIENT (
    ingredient_id INTEGER PRIMARY KEY,
    name VARCHAR(255),
    description TEXT
);

-- Table RECIPE_INGREDIENT
CREATE TABLE RECIPE_INGREDIENT (
    recipe_id INTEGER,
    ingredient_id INTEGER,
    quantity DECIMAL(10, 2),
    unit VARCHAR(50),
    PRIMARY KEY (recipe_id, ingredient_id),
    FOREIGN KEY (recipe_id) REFERENCES RECIPE(recipe_id),
    FOREIGN KEY (ingredient_id) REFERENCES INGREDIENT(ingredient_id)
);

-- Table COMMENT
CREATE TABLE COMMENT (
    comment_id INTEGER PRIMARY KEY,
    recipe_id INTEGER,
    user_id INTEGER,
    content TEXT,
    creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (recipe_id) REFERENCES RECIPE(recipe_id),
    FOREIGN KEY (user_id) REFERENCES USERS(user_id)
);

-- Table RATING
CREATE TABLE RATING (
    rating_id INTEGER PRIMARY KEY,
    recipe_id INTEGER,
    user_id INTEGER,
    score INTEGER,
    creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (recipe_id) REFERENCES RECIPE(recipe_id),
    FOREIGN KEY (user_id) REFERENCES USERS(user_id)
);

-- Table SESSION
CREATE TABLE SESSION (
    session_id INTEGER PRIMARY KEY,
    user_id INTEGER,
    admin_id INTEGER,
    session_token VARCHAR(255),
    ip_address VARCHAR(45),
    user_agent VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    expired BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES USERS(user_id),
    FOREIGN KEY (admin_id) REFERENCES ADMIN(admin_id)
);
